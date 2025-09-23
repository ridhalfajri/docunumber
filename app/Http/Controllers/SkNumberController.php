<?php

namespace App\Http\Controllers;

use App\Models\SkNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class SkNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skNumbers = SkNumber::orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Mengembalikan response sukses dengan data SkNumber yang sudah diurutkan
        return $this->successResponse(
            'Data retrieved successfully',
            $skNumbers,
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|date_format:Y-m-d',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return $this->errorResponse(
                'Validation Error',
                $validator->errors(),
                422
            );
        }
        //counter jika db belum ada isinya
        $skCount = SkNumber::count();
        if ($skCount === 0) {
            $newSkFormat = '1/KEP/BSN/' . Carbon::now()->format('m') . '/' . Carbon::now()->format('Y');

            $skNumber = new SkNumber();
            $skNumber->sk_number = $newSkFormat;
            $skNumber->date = Carbon::parse($request->date);
            $skNumber->is_verified = false;
            $skNumber->save();

            return $this->successResponse(
                "SK number created successfully (first record)",
                $skNumber,
                201,
                now()->toDateTimeString()
            );
        }
        //validate tanggal request sekarang atau bukan
        if ($request->date == Carbon::now()->format('Y-m-d')) {
            $dateNow = Carbon::parse($request->date);

            // Loop untuk mencari SK terakhir pada tanggal tersebut atau mundur satu hari
            while (true) {
                // Cek apakah ada data pada tanggal tersebut
                $lastSkNumber = SkNumber::where('date', $dateNow)
                    ->orderBy('created_at', 'desc')->orderBy('date', 'desc')
                    ->first();
                if ($lastSkNumber) {
                    break;
                }

                // Jika tidak ada data, mundur satu hari dan coba lagi
                $dateNow->subDay();
            }

            // Ambil angka pertama dari SK terakhir
            preg_match('/^\d+/', $lastSkNumber->sk_number, $matches);

            if (!empty($matches)) {
                $firstNumber = $matches[0];// Ambil angka pertama (misalnya 2 atau 10)
            } else {
                return $this->errorResponse(
                    "SK number doesn't match the expected format",
                    null,
                    422
                );
            }

            // Increment angka pertama dan buat format SK number baru
            $newFirstNumber = $firstNumber + 1;
            $parts = explode('/', $lastSkNumber->sk_number);
            $year = end($parts);
            if($year != Carbon::now()->format('Y')){
                $newSkFormat ='1/KEP/BSN/'.Carbon::now()->format('m').'/' . Carbon::now()->format('Y');
            }else{
                $newSkFormat = $newFirstNumber . '/KEP/BSN/'.Carbon::now()->format('m').'/' . Carbon::now()->format('Y');
            }

            // Buat SK number baru
            $skNumber = new SkNumber();
            $skNumber->sk_number = $newSkFormat;
            $skNumber->date = Carbon::parse($request->date);
            $skNumber->is_verified = false;
            $skNumber->save();

            return $this->successResponse(
                "SK number created successfully",
                $skNumber,
                201,
                now()->toDateTimeString()
            );
        }else {
            $backDate = Carbon::parse($request->date);

            // Cari data sebelum atau sama dengan tanggal request
            $lastSkNumber = SkNumber::where('date', '<=', $backDate)
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$lastSkNumber) {
                // Tidak ada data sebelum tanggal request → mulai counter baru
                $newSkFormat = '1/KEP/BSN/' . $backDate->format('m') . '/' . $backDate->format('Y');
                $isExist = SkNumber::where('sk_number', $newSkFormat)->first();
                if ($isExist) {
                    return $this->errorResponse(
                        "SK number already exist",
                        null,
                        400
                    );
                }
            } else {
                // Ada data sebelumnya → generate nomor dengan tambahan huruf
                $newSkFormat = $this->addLetterToSkNumber($lastSkNumber->sk_number);

                // Cek apakah nomor sudah ada
                $isExist = SkNumber::where('sk_number', $newSkFormat)->exists();
                if ($isExist) {
                    return $this->errorResponse(
                        "Unable to generate SK number because the selected date has passed the allowed limit.",
                        null,
                        400
                    );
                }
            }

            // Buat SK number baru
            $skNumber = new SkNumber();
            $skNumber->sk_number = $newSkFormat;
            $skNumber->date = $backDate;
            $skNumber->is_verified = false;
            $skNumber->save();

            return $this->successResponse(
                "SK number created successfully",
                $skNumber,
                201,
                now()->toDateTimeString()
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function verifySkDate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'sk_number' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return $this->errorResponse(
                'Validation Error',
                $validator->errors(),
                422
            );
        }// Jika validasi gagal
        $skNumber = SkNumber::where('sk_number',$request->sk_number)->first();
        if ($skNumber) {
            $skNumber->is_verified = true;
            $skNumber->verified_at = Carbon::now();
            $skNumber->save();
            return $this->successResponse(
                "SK number verified successfully",
                $skNumber,
                200
            );
        }
        return $this->errorResponse(
            "SK number doesn't match the selected sk number.",
            null,
            400
        );

    }

    private function addLetterToSkNumber($skNumber)
    {
        // Pisahkan angka pertama dan bagian lainnya dari sk_number
        preg_match('/^(\d+)([A-Z]*)(\/KEP\/BSN\/\d+\/\d{4})/', $skNumber, $matches);

        // Jika format sk_number sesuai
        if (count($matches) === 4) {
            $number = $matches[1];  // Ambil angka pertama, misalnya "2"
            $letters = $matches[2];  // Ambil huruf, misalnya "A" jika ada
            $rest = $matches[3];     // Ambil bagian setelah angka pertama dan huruf, misalnya "/KEP/BSN/1/2025"

            // Jika sudah ada huruf, tambahkan huruf berikutnya, jika tidak, tambahkan huruf "A"
            if ($letters) {
                // Ambil huruf terakhir yang ada dan tambahkan huruf berikutnya
                $newLetter = $this->getNextLetter($letters);
            } else {
                // Jika belum ada huruf, tambahkan huruf "A"
                $newLetter = 'A';
            }

            // Gabungkan angka dan huruf baru dengan bagian lainnya
            $newSkNumber = $number . $newLetter . $rest;

            return $newSkNumber;
        }

        return null;
    }

    private function getNextLetter($letters)
    {
        // Jika huruf sudah ada, proses menjadi format basis 26
        $letterArray = str_split(strrev($letters)); // Membalik huruf untuk mempermudah perhitungan
        $carry = true;
        $newLetter = '';

        foreach ($letterArray as $char) {
            if ($carry) {
                // Jika huruf terakhir adalah 'Z', ubah menjadi 'A' dan bawa carry ke huruf sebelumnya
                if ($char == 'Z') {
                    $newLetter = 'A' . $newLetter; // Tambahkan 'A' di depan
                } else {
                    // Jika tidak 'Z', tambah 1 ke huruf terakhir
                    $newLetter = chr(ord($char) + 1) . $newLetter;
                    $carry = false; // Tidak perlu lanjutkan bawa carry ke huruf sebelumnya
                }
            } else {
                $newLetter = $char . $newLetter; // Huruf lainnya tetap sama
            }
        }

        // Jika masih ada carry (misalnya dari 'Z' menjadi 'AA')
        if ($carry) {
            $newLetter = 'A' . $newLetter; // Menambah huruf A di depan
        }
        return $newLetter;
    }



}
