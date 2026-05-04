<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Termin Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #dc2626 0%, #ea580c 100%); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; border-radius: 0 0 8px 8px; }
        .btn { display: inline-block; background: #dc2626; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin-top: 20px; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PT. Sinom Jati Mas</h1>
            <p>Portal Manajemen Proyek</p>
        </div>
        <div class="content">
            <h2>Notifikasi Termin Tercapai</h2>
            <p>Halo Tim Keuangan,</p>
            <p>Progress proyek berikut telah mencapai termin <strong>{{ $terminPercentage }}%</strong>:</p>

            <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;"><strong>Nama Proyek</strong></td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{ $project->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;"><strong>Klien</strong></td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{ $project->client->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;"><strong>Lokasi</strong></td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{ $project->location ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;"><strong>Progress Saat Ini</strong></td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{ $project->progress_percentage }}%</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;"><strong>Nilai Kontrak</strong></td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">Rp {{ number_format($project->contract_value, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;"><strong>Nominal Termin ({{ $terminPercentage }}%)</strong></td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">Rp {{ number_format($terminAmount, 0, ',', '.') }}</td>
                </tr>
            </table>

            <p>Silakan segera membuat draft invoice untuk termin ini melalui portal admin.</p>

            <a href="{{ route('admin.invoices.create') }}?project_id={{ $project->id }}&termin={{ $terminPercentage }}" class="btn">Buat Invoice Sekarang</a>

            <p style="margin-top: 30px; font-size: 12px; color: #6b7280;">
                Email ini dikirim secara otomatis oleh sistem PT. Sinom Jati Mas.
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} PT. Sinom Jati Mas. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
