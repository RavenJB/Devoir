import asyncio
import edge_tts

async def text_to_speech(text: str, voice: str, output_file: str) -> None:
    communication = edge_tts.Communicate(text, voice)
    await communication.save(output_file+".mp3")
    print("Le fichier audio a été créé avec succès !")

def main():
    text = input("Entrez le texte à convertir en parole : ")
    output_file = input("Entrez le nom du fichier de sortie (avec extension .mp3) : ")
    voice = "fr-FR-HenriNeural"  

    loop = asyncio.new_event_loop()
    asyncio.set_event_loop(loop)
    try:
        loop.run_until_complete(text_to_speech(text, voice, output_file))
    finally:
        loop.close()

if __name__ == "__main__":
    main()