<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: 'Montserrat', sans-serif;
                font-size: 16px;
                color: #2e2e2e;
                line-height: 1.6;
                display: flex;
                flex-direction: column;
            }
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Montserrat', sans-serif;
                font-weight: 600;
                color: #eb6566;
                margin-top: 0;
            }

            p {
                margin-bottom: 1em;
                font-weight: 400;
            }
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
        <div class="section"><span class="label">Dosis:</span> {{ $prescription->dosage }}</div>
        <div class="section"><span class="label">Instrucciones:</span> {{ $prescription->instructions }}</div>
        <div class="section"><span class="label">Duración:</span> {{ $prescription->duration }}</div>
        <div class="section"><span class="label">Fecha de prescripción:</span> {{ \Carbon\Carbon::parse($prescription->created_at)->format('d/m/Y H:i') }}</div>
    </body>
</html>