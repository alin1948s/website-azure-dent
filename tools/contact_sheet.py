from pathlib import Path

from PIL import Image, ImageDraw

folder = Path(__file__).resolve().parents[1] / "theme" / "azur-dent" / "assets" / "images"
files = sorted(folder.glob("*-1280.webp"))
tile = (320, 230)
sheet = Image.new("RGB", (tile[0] * 4, (tile[1] + 34) * 2), "white")
draw = ImageDraw.Draw(sheet)

for index, file in enumerate(files):
    photo = Image.open(file)
    photo.thumbnail(tile)
    x = (index % 4) * tile[0]
    y = (index // 4) * (tile[1] + 34)
    sheet.paste(photo, (x, y))
    draw.text((x + 6, y + tile[1] + 5), file.name, fill="black")

output = Path(__file__).resolve().parent / "contact-sheet.jpg"
sheet.save(output, quality=88)
print(output)
