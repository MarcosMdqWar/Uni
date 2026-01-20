from diffusers import StableDiffusionPipeline
import PySimpleGUI as sg
from PIL import ImageStat
import os
import cv2
import numpy as np

# Función para calcular características de la imagen
def calcular_caracteristicas(img):
    stat = ImageStat.Stat(img)
    
    # Redondear solo el promedio RGB a 2 decimales
    rgb_avg = [round(value, 2) for value in stat.mean[:3]]
    brillo_promedio = sum(stat.mean) / len(stat.mean)
    contraste_promedio = sum(stat.stddev) / len(stat.stddev)
    return rgb_avg, brillo_promedio, contraste_promedio

# Función para calcular la simetría de la imagen
def calcular_simetria(imagen):
    height, width = imagen.shape[:2]
    
    # Asegurar que el ancho sea par
    if width % 2 != 0:
        width -= 1
        imagen = imagen[:, :width]  # Recortar 1 pixel de la derecha para hacer el ancho par
    
    left_half = imagen[:, :width // 2]
    right_half = imagen[:, width // 2:]
    
    right_half_flipped = np.fliplr(right_half)
    difference = cv2.absdiff(left_half, right_half_flipped)
    total_pixels = height * (width // 2)
    non_matching_pixels = np.sum(difference > 10)
    symmetry_score = 100 - (non_matching_pixels / total_pixels * 100)
    
    return symmetry_score

# Función para mostrar características de la imagen
def mostrar_caracteristicas(imagen_numero, rgb_avg, brillo_promedio, contraste_promedio, simetria):
    return (f"Imagen {imagen_numero}\n"
            f"Promedio RGB: {rgb_avg}\n"
            f"Brillo promedio: {brillo_promedio:.2f}\n"
            f"Contraste promedio: {contraste_promedio:.2f}\n"
            f"Simetría: {simetria:.2f}%")

device = "cpu"
print(f"Usando dispositivo: {device}")
model_id = "prompthero/openjourney-v4"
pipe = StableDiffusionPipeline.from_pretrained(model_id)
pipe = pipe.to(device)

# Definir el layout de la interfaz
layout = [
    [sg.Text("Ingrese el prompt para generar las imágenes:")],
    [sg.InputText(key="prompt"), sg.Text("Negative Prompt (Opcional):"), sg.InputText(key="negative_prompt")],
    [sg.Button("Generar Imágenes")],
    [sg.Column([[sg.Image(key="img1")],
                 [sg.Text("Características de la Imagen 1:", key="text1")]]),
                 sg.Column([[sg.Image(key="img2")],
                 [sg.Text("Características de la Imagen 2:", key="text2")]])],
    [sg.Button("Seleccionar Imagen 1"), sg.Button("Seleccionar Imagen 2"), sg.Exit()]
]

window = sg.Window("Generador de Imágenes con Stable Diffusion", layout)
img_counter = 1

while True:
    event, values = window.read()
    if event == sg.WINDOW_CLOSED or event == "Exit":
        break

    if event == "Generar Imágenes":
        prompt = values["prompt"]
        negative_prompt = values["negative_prompt"]
        
        if len(prompt) == 0:
            sg.popup("Por favor, ingresa un prompt.")
            continue

        # Generar imágenes
        img1 = pipe(prompt, negative_prompt=negative_prompt, height=512, width=512, num_inference_steps=20).images[0]
        img2 = pipe(prompt, negative_prompt=negative_prompt, height=512, width=512, num_inference_steps=20).images[0]

        img1.save(f"img{img_counter}_1.png")
        img2.save(f"img{img_counter}_2.png")

        # Convertir imágenes a escala de grises para calcular la simetría
        img1_gray = np.array(img1.convert('L'))
        img2_gray = np.array(img2.convert('L'))

        # Calcular la simetría de las imágenes
        simetria_img1 = calcular_simetria(img1_gray)
        simetria_img2 = calcular_simetria(img2_gray)

        # Calcular características de las imágenes
        rgb_avg1, brillo_prom1, contraste_prom1 = calcular_caracteristicas(img1)
        rgb_avg2, brillo_prom2, contraste_prom2 = calcular_caracteristicas(img2)

        # Actualizar la interfaz con las imágenes y características
        window["img1"].update(filename=f"img{img_counter}_1.png")
        window["img2"].update(filename=f"img{img_counter}_2.png")
        window["text1"].update(mostrar_caracteristicas(1, rgb_avg1, brillo_prom1, contraste_prom1, simetria_img1))
        window["text2"].update(mostrar_caracteristicas(2, rgb_avg2, brillo_prom2, contraste_prom2, simetria_img2))

    # Regenerar la primera imagen basada en las características de la segunda imagen
    if event == "Seleccionar Imagen 2":
        sg.popup("Regenerando Imagen 1 en base a las características de Imagen 2...")

        # Usar las características de Imagen 2 en el prompt
        new_prompt = f"{prompt}, colores promedio RGB {rgb_avg2}, brillo {brillo_prom2:.2f}, contraste {contraste_prom2:.2f}, simetría {simetria_img2:.2f}%"
        img1 = pipe(new_prompt, negative_prompt=negative_prompt, height=512, width=512, num_inference_steps=25).images[0]

        img1.save(f"img{img_counter}_1_regenerated.png")
        rgb_avg1, brillo_prom1, contraste_prom1 = calcular_caracteristicas(img1)
        img1_gray = np.array(img1.convert('L'))
        simetria_img1 = calcular_simetria(img1_gray)
        window["img1"].update(filename=f"img{img_counter}_1_regenerated.png")
        window["text1"].update(mostrar_caracteristicas(1, rgb_avg1, brillo_prom1, contraste_prom1, simetria_img1))

    # Regenerar la segunda imagen basada en las características de la primera imagen
    if event == "Seleccionar Imagen 1":
        sg.popup("Regenerando Imagen 2 en base a las características de Imagen 1...")

        # Usar las características de Imagen 1 en el prompt
        new_prompt = f"{prompt}, colores promedio RGB {rgb_avg1}, brillo {brillo_prom1:.2f}, contraste {contraste_prom1:.2f}, simetría {simetria_img1:.2f}%"
        img2 = pipe(new_prompt, negative_prompt=negative_prompt, height=512, width=512, num_inference_steps=25).images[0]

        img2.save(f"img{img_counter}_2_regenerated.png")
        rgb_avg2, brillo_prom2, contraste_prom2 = calcular_caracteristicas(img2)
        img2_gray = np.array(img2.convert('L'))
        simetria_img2 = calcular_simetria(img2_gray)
        window["img2"].update(filename=f"img{img_counter}_2_regenerated.png")
        window["text2"].update(mostrar_caracteristicas(2, rgb_avg2, brillo_prom2, contraste_prom2, simetria_img2))

window.close()

# Eliminar archivos generados
for file in os.listdir():
    if file.endswith(".png"):
        os.remove(file)
