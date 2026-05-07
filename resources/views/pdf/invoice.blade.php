<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .header {
            border-bottom: 4px solid #ea580c;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo-section {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #dc2626, #ea580c);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 24px;
            margin-right: 15px;
        }
        .company-info h1 {
            color: #dc2626;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .company-info p {
            color: #666;
            font-size: 10px;
            margin: 2px 0;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h2 {
            color: #ea580c;
            font-size: 28px;
            font-weight: bold;
        }
        .invoice-title p {
            color: #666;
            margin-top: 5px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .invoice-details table {
            width: 100%;
        }
        .invoice-details td {
            padding: 5px 0;
        }
        .invoice-details .label {
            color: #666;
            width: 150px;
        }
        .invoice-details .value {
            font-weight: bold;
            color: #333;
        }
        .section-title {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            padding: 10px 15px;
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 12px;
            text-transform: uppercase;
        }
        .info-box {
            margin-bottom: 25px;
        }
        .info-box h4 {
            color: #dc2626;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 8px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .info-box p {
            margin: 3px 0;
            color: #444;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .items-table th {
            background: #dc2626;
            color: white;
            padding: 12px 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
        }
        .items-table tr:nth-child(even) {
            background: #fafafa;
        }
        .total-section {
            margin-top: 20px;
            border-top: 2px solid #dc2626;
            padding-top: 15px;
        }
        .total-row {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin: 8px 0;
        }
        .total-label {
            width: 150px;
            text-align: right;
            color: #666;
        }
        .total-value {
            width: 200px;
            text-align: right;
            font-weight: bold;
        }
        .grand-total {
            font-size: 16px;
            color: #dc2626;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-draft { background: #f3f4f6; color: #6b7280; }
        .status-sent { background: #dbeafe; color: #1d4ed8; }
        .status-overdue { background: #fee2e2; color: #dc2626; }
        .status-paid { background: #d1fae5; color: #059669; }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 200px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 10px;
        }
        .terms {
            margin-top: 30px;
            padding: 15px;
            background: #fafafa;
            border-radius: 5px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td style="width: 60%;">
                    <div class="logo-section">
                        <div class="logo-icon">S</div>
                        <div class="company-info">
                            <h1>PT. SINOM JATI MAS</h1>
                            <p>General Contractor & General Trading</p>
                            <p>Link. Sukarela RT/RW 006/001, Kel. Mekarsari, Kec. Pulomerak</p>
                            <p>Email: sinomjatimas@gmail.com | Telp: 087771300570</p>
                        </div>
                    </div>
                </td>
                <td style="width: 40%; vertical-align: top;">
                    <div class="invoice-title">
                        <h2>INVOICE</h2>
                        <p>No: <strong>{{ $invoice->invoice_number }}</strong></p>
                        <p>Tanggal: {{ $invoice->created_at->format('d F Y') }}</p>
                        <p style="margin-top: 10px;">
                            <span class="status-badge status-{{ $invoice->status }}">{{ $invoice->status_label }}</span>
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table style="width: 100%; margin-bottom: 30px;">
        <tr>
            <td style="width: 50%; vertical-align: top; padding-right: 20px;">
                <div class="info-box">
                    <h4>Ditagihkan Kepada:</h4>
                    <p style="font-size: 14px; font-weight: bold; color: #333;">{{ $invoice->project->client->name }}</p>
                    <p>{{ $invoice->project->client->email }}</p>
                    <p>{{ $invoice->project->client->phone ?? '-' }}</p>
                </div>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <div class="info-box">
                    <h4>Detail Proyek:</h4>
                    <p style="font-weight: bold;">{{ $invoice->project->name }}</p>
                    <p>{{ $invoice->project->location ?? 'Lokasi belum ditentukan' }}</p>
                    <p>Progress: {{ $invoice->project->progress_percentage }}%</p>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Rincian Pembayaran</div>
    
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 55%;">Deskripsi</th>
                <th style="width: 20%;">Termin</th>
                <th style="width: 20%; text-align: right;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>
                    <strong>Pembayaran Termin {{ $invoice->termin_percentage }}%</strong><br>
                    <span style="color: #666; font-size: 10px;">{{ $invoice->project->name }}</span>
                </td>
                <td>{{ $invoice->termin_percentage }}%</td>
                <td style="text-align: right;">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <div class="total-label">Subtotal:</div>
            <div class="total-value">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</div>
        </div>
        <div class="total-row">
            <div class="total-label">PPN (11%):</div>
            <div class="total-value">-</div>
        </div>
        <div class="total-row grand-total">
            <div class="total-label" style="color: #dc2626;">TOTAL:</div>
            <div class="total-value" style="color: #dc2626;">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="terms">
        <strong>Ketentuan:</strong><br>
        1. Pembayaran dilakukan sesuai dengan termin yang telah disepakati dalam kontrak.<br>
        2. Invoice ini sah dan diproses oleh sistem PT. Sinom Jati Mas.<br>
        3. Jatuh tempo pembayaran: {{ $invoice->due_date ? $invoice->due_date->format('d F Y') : 'Sesuai kontrak' }}
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p style="margin-bottom: 10px;">Dibuat oleh,</p>
            <div class="signature-line">
                <strong>{{ $invoice->creator->name }}</strong><br>
                <span style="font-size: 10px;">{{ $invoice->created_at->format('d F Y') }}</span>
            </div>
        </div>
        <div class="signature-box">
            <p style="margin-bottom: 10px;">Disetujui,</p>
            <div class="signature-line">
                <strong>PT. SINOM JATI MAS</strong><br>
                <span style="font-size: 10px;">Management</span>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>PT. SINOM JATI MAS - General Contractor & General Trading</p>
        <p>Link. Sukarela RT/RW 006/001, Kel. Mekarsari, Kec. Pulomerak | Email: sinomjatimas@gmail.com | Telp: 087771300570</p>
        <p style="margin-top: 5px;">Dokumen ini digenerate secara otomatis oleh sistem pada {{ now()->format('d F Y H:i') }}</p>
    </div>
</body>
</html>
