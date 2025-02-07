import sys
import csv
from fuzzywuzzy import fuzz

def compare_files(source_file, catalog_file, output_file):
    # Leer el archivo de fuente
    with open(source_file, 'r') as f:
        source_data = list(csv.reader(f))

    # Leer el archivo de catálogo
    with open(catalog_file, 'r') as f:
        catalog_data = list(csv.reader(f))

    # Abrir el archivo de salida
    with open(output_file, 'w') as f:
        writer = csv.writer(f)
        writer.writerow(["id_store"])  # Encabezado del archivo de salida

        # Comparar cada URL del archivo de fuente con las del catálogo
        for row in source_data:
            id_store = row[0]
            publisher_url = row[1]

            # Comprobar similitudes con cada URL del catálogo
            is_duplicate = False
            for catalog_row in catalog_data:
                catalog_url = catalog_row[0]
                similarity = fuzz.ratio(publisher_url, catalog_url)

                if similarity >= 85:
                    is_duplicate = True
                    break  # Si encuentra un duplicado, se detiene

            if not is_duplicate:
                writer.writerow([id_store])  # Escribir el id_store en el archivo de salida

if __name__ == "__main__":
    # Obtener los archivos de entrada y salida
    source_file = sys.argv[1]
    catalog_file = sys.argv[2]
    output_file = sys.argv[3]

    # Comparar los archivos
    compare_files(source_file, catalog_file, output_file)
