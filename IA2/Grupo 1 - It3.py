import torch
from diffusers import StableDiffusionPipeline
import PySimpleGUI as sg
from PIL import Image, ImageStat
import os
def calcular_caracteristicas(img):
    stat = ImageStat.Stat(img)
    rgb_avg = stat.mean[:3]
    brillo_promedio = sum(stat.mean) / len(stat.mean)
    contraste_promedio = sum(stat.stddev) / len(stat.stddev)
    return rgb_avg, brillo_promedio, contraste_promedio
def mostrar_caracteristicas(imagen_numero, rgb_avg, brillo_promedio, contraste_promedio):
    return f"Imagen {imagen_numero}\nPromedio RGB: {rgb_avg}\nBrillo promedio: {brillo_promedio:.2f}\nContraste promedio: {contraste_promedio:.2f}"
device = "cpu"
print(f"Usando dispositivo: {device}")
model_id = "prompthero/openjourney-v4"
pipe = StableDiffusionPipeline.from_pretrained(model_id)
pipe = pipe.to(device)
layout = [
    [sg.Text("Ingrese el prompt para generar las imágenes:")],
    [sg.InputText(key="prompt"), sg.Text("Negative Prompt (Opcional):"), sg.InputText(key="negative_prompt")],
    [sg.Button("Generar Imágenes")],
    [sg.Image(key="img1"), sg.Image(key="img2")],
    [sg.Text("Características de la Imagen 1:", key="text1")],
    [sg.Text("Características de la Imagen 2:", key="text2")],
    [sg.Button("Seleccionar Imagen 1"), sg.Button("Seleccionar Imagen 2"), sg.Exit()]
]
window = sg.Window("Generador de Imágenes con Stable Diffusion", layout)
img_counter = 1
img1_selected = False
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
        img1 = pipe(prompt, negative_prompt=negative_prompt, height=512, width=512, num_inference_steps=20).images[0]
        img2 = pipe(prompt, negative_prompt=negative_prompt, height=512, width=512, num_inference_steps=20).images[0]
        img1.save(f"img{img_counter}_1.png")
        img2.save(f"img{img_counter}_2.png")
        rgb_avg1, brillo_prom1, contraste_prom1 = calcular_caracteristicas(img1)
        rgb_avg2, brillo_prom2, contraste_prom2 = calcular_caracteristicas(img2)
        window["img1"].update(filename=f"img{img_counter}_1.png")
        window["img2"].update(filename=f"img{img_counter}_2.png")
        window["text1"].update(mostrar_caracteristicas(1, rgb_avg1, brillo_prom1, contraste_prom1))
        window["text2"].update(mostrar_caracteristicas(2, rgb_avg2, brillo_prom2, contraste_prom2))
    if event == "Seleccionar Imagen 1":
        sg.popup("Seleccionaste la Imagen 1")
        img1_selected = True
    if event == "Seleccionar Imagen 2":
        sg.popup("Seleccionaste la Imagen 2")
        img1_selected = False
        #Regenerar la primera imagen basada en la segunda imagen
        sg.popup("Regenerando Imagen 1 en base a las características de Imagen 2...")
        img1 = pipe(prompt, negative_prompt=negative_prompt, height=512, width=512, num_inference_steps=25).images[0]
        img1.save(f"img{img_counter}_1_regenerated.png")
        #Calcular nuevas características de la imagen regenerada
        rgb_avg1, brillo_prom1, contraste_prom1 = calcular_caracteristicas(img1)
        #Actualizar la interfaz
        window["img1"].update(filename=f"img{img_counter}_1_regenerated.png")
        window["text1"].update(mostrar_caracteristicas(1, rgb_avg1, brillo_prom1, contraste_prom1))
    if img1_selected:
        sg.popup("Regenerando Imagen 2 en base a las características de Imagen 1...")
        img2 = pipe(prompt, negative_prompt=negative_prompt, height=512, width=512, num_inference_steps=25).images[0]
        img2.save(f"img{img_counter}_2_regenerated.png")
        rgb_avg2, brillo_prom2, contraste_prom2 = calcular_caracteristicas(img2)
        window["img2"].update(filename=f"img{img_counter}_2_regenerated.png")
        window["text2"].update(mostrar_caracteristicas(2, rgb_avg2, brillo_prom2, contraste_prom2))      
window.close()
for file in os.listdir():
    if file.endswith(".png"):
        os.remove(file)
