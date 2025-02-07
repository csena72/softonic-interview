#!/bin/bash

# Rutas de los archivos CSV
SOURCE_FILE="/app/storage/app/data_dumps/source_publisher-url.csv"
CATALOG_FILE="/app/storage/app/data_dumps/catalog_publisher-url.csv"
OUTPUT_FILE="/app/storage/app/data_dumps/non_duplicates.csv"

# Verificar que los archivos existen
if [[ ! -f "$SOURCE_FILE" ]] || [[ ! -f "$CATALOG_FILE" ]]; then
    echo "Error: Uno de los archivos no existe."
    exit 1
fi

# Crear el archivo de salida y escribir encabezado
echo "id_store" > "$OUTPUT_FILE"

# Leer línea por línea el archivo source
while IFS=, read -r id_store publisher_url; do
    # Verificar si publisher_url existe en catalog_file
    if ! grep -Fq "$publisher_url" "$CATALOG_FILE"; then
        echo "$id_store" >> "$OUTPUT_FILE"
    fi
done < <(tail -n +2 "$SOURCE_FILE") # Omitimos la primera línea (encabezado)

echo "Proceso completado. No duplicados guardados en $OUTPUT_FILE"
