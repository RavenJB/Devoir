import asyncio
import edge_tts


TEXT = "Bonjour, comment ça va ?"
VOICE = "fr-FR-HenriNeural"
OUTPUT_FILE = "audio.mp3"

async def amain() -> None:
    communication = edge_tts.Communicate(TEXT, VOICE)
    await communication.save(OUTPUT_FILE)

loop = asyncio.new_event_loop()
asyncio.set_event_loop(loop)
try:
    loop.run_until_complete(amain())
finally:
    loop.close()
