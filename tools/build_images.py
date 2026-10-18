"""Download and optimize the Pexels stock images used by the Azur Dent theme."""

from pathlib import Path
from urllib.request import Request, urlopen
from io import BytesIO
from PIL import Image, ImageOps


ROOT = Path(__file__).resolve().parents[1]
OUT = ROOT / "theme" / "azur-dent" / "assets" / "images"
PHOTOS = {
    "chair-room": 6812461,
    "reception": 8459996,
    "treatment-chair": 4269264,
    "consultation-model": 4269369,
    "patient-checkup": 3845653,
    "consultation-tablet": 5355703,
    "instrument-drawer": 6502551,
    "tools-teal": 17301013,
}


def download(photo_id: int) -> bytes:
    url = (
        f"https://images.pexels.com/photos/{photo_id}/"
        f"pexels-photo-{photo_id}.jpeg?auto=compress&cs=tinysrgb&w=1900"
    )
    request = Request(url, headers={"User-Agent": "AzurDentThemeAssetBuilder/1.0"})
    with urlopen(request, timeout=45) as response:
        if "image/" not in response.headers.get("Content-Type", ""):
            raise RuntimeError(f"Unexpected response for Pexels photo {photo_id}")
        return response.read()


def main() -> None:
    OUT.mkdir(parents=True, exist_ok=True)
    for name, photo_id in PHOTOS.items():
        image = Image.open(BytesIO(download(photo_id)))
        image = ImageOps.exif_transpose(image).convert("RGB")
        for width in (720, 1280, 1800):
            ratio = min(width / image.width, 1)
            size = (round(image.width * ratio), round(image.height * ratio))
            optimized = image.resize(size, Image.Resampling.LANCZOS)
            optimized.save(
                OUT / f"{name}-{width}.webp",
                "WEBP",
                quality=82,
                method=6,
            )
        print(f"Optimized {name} from Pexels photo {photo_id}: {image.size}")


if __name__ == "__main__":
    main()
