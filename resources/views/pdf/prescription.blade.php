<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: sans-serif; font-size: 16px; line-height: 1.5; }
            h2 { text-align: center; margin-bottom: 25px; }
            .section { margin-bottom: 12px; }
            .label { font-weight: bold; }
            h1{font-size:20px !important;}
        </style>
    </head>
    <body>
        <h2>Prescripción Médica</h2>
        <br/>
        <h3>Pauta de medicación:</h3>
        <div class="section"><span class="label">Medicamento:</span> {{ $prescription->medication }}</div>
        <div class="section"><span class="label">Dosificación:</span> {{ $prescription->dosage }}</div>
        <div class="section"><span class="label">Instrucciones:</span> {{ $prescription->instructions }}</div>
        <div class="section"><span class="label">Duración:</span> {{ $prescription->duration }}</div>
        <div class="section"><span class="label">Fecha de prescripción:</span> {{ \Carbon\Carbon::parse($prescription->created_at)->format('d/m/Y H:i') }}</div>
    </body>
</html>