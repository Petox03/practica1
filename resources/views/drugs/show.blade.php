<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicamento - {{ $my_drug->name }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 0;">
    <div class="card-actions justify-end">
        <a href="{{ url('/api/drugs/pdf/' . $my_drug->id) }}" 
           class="btn btn-secondary w-full"
           target="_blank">Guardar como PDF</a>
    </div>
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px;">
        <div style="width: 100%; max-width: 600px; border: 1px solid #e5e7eb; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;">
            <!-- Imagen del Medicamento -->
            <div style="width: 100%; height: auto;">
                <img src="data:image/jpg;base64, {{ base64_encode(file_get_contents(public_path("storage\\".$my_drug->img))) }}" alt="{{ $my_drug->name }}" style="width: 100%; height: 500px; object-fit: cover; display: block; border-top-left-radius: 8px; border-top-right-radius: 8px;">
            </div>

            <div style="padding: 16px;">
                <!-- Nombre del Medicamento -->
                <h1 style="font-size: 24px; font-weight: bold; color: #111827; text-align: center; margin-bottom: 8px;">{{ $my_drug->name }}</h1>

                <!-- Descripción -->
                <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin-bottom: 16px;">{{ $my_drug->description }}</p>

                <!-- Detalles adicionales -->
                <div style="margin-bottom: 16px;">
                    <p style="font-size: 14px; color: #4b5563; margin: 0 0 4px 0;"><strong>Cantidad por paquete:</strong> {{ $my_drug->quantity }}</p>
                    <p style="font-size: 18px; font-weight: bold; color: #111827; margin: 0;"><strong>Precio:</strong> ${{ number_format($my_drug->price, 2) }}</p>
                </div>

                <!-- Calificación -->
                <div style="display: flex; align-items: center; margin-bottom: 16px;">
                    <div style="display: flex; margin-right: 8px;">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20" style="width: 20px; height: 20px; color: {{ $i <= 4 ? '#facc15' : '#e5e7eb' }};">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                            </svg>
                        @endfor
                    </div>
                    <span style="background-color: #bfdbfe; color: #1d4ed8; font-size: 12px; font-weight: bold; padding: 4px 8px; border-radius: 4px;">{{ $my_drug->rating ?? '4.0' }}</span>
                </div>

                <!-- Botón de Acción -->
                <div style="text-align: center; margin-top: 16px;">
                    <a href="{{ route('index') }}" style="display: inline-block; background-color: #2563eb; color: #ffffff; font-size: 14px; font-weight: bold; text-decoration: none; padding: 10px 20px; border-radius: 4px;">Comprar</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
