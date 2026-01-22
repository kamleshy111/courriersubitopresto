use Illuminate\Support\Facades\URL;
use App\Models\Waybill;

public function generateTemporaryPdfUrl($waybillId)
{
    // Find the waybill by the given ID
    $waybill = Waybill::findOrFail($waybillId); // Make sure the waybill exists

    // Generate the signed URL for the single waybill
    $signedUrl = URL::temporarySignedRoute('pdf.view', now()->addMinutes(10), [
        'waybill' => $waybill->id, // Pass the single waybill ID
    ]);

    return response()->json([
        'url' => $signedUrl,
    ]);
}
