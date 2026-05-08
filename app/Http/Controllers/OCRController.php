<?php

namespace App\Http\Controllers;

use App\Services\AIService;
use Illuminate\Http\Request;

class OCRController extends Controller
{
    public function parse(Request $request)
    {
        $request->validate([
            'ocr_text' => 'required|string',
        ]);

        $aiService = new AIService;
        $result = $aiService->extractIdentityData($request->input('ocr_text'));

        return response()->json($result);
    }

    public function parseInvoice(Request $request)
    {
        $request->validate([
            'ocr_text' => 'required|string',
        ]);

        $ai = new AIService;
        $result = $ai->extractTransactionData($request->ocr_text);

        return response()->json($result);
    }
}
