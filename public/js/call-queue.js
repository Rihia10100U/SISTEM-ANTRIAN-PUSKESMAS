async function playQueueSound(message) {

    const voices = await getVoices()

    const idVoices = voices.filter(v => {
        return v.lang.includes("id")
    })

    const idWomanVoice = idVoices[idVoices.length - 1]

    const speech = new SpeechSynthesisUtterance(message)
    
    speech.voice = idWomanVoice
    
    speech.rate = 0.8

    window.speechSynthesis.speak(speech)

}

function getVoices() {
    return new Promise((resolve, reject) => {
        id = setInterval(() => {
            const voices = window.speechSynthesis.getVoices()
            if (voices.length) {
                resolve(voices)
                clearInterval(id)
            }
        }, 10)
    })
}

document.addEventListener('livewire:initialized', () => {
    Livewire.on('queue-called', playQueueSound)
})