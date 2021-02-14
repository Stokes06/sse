const mainElement = document.getElementById("main");

let mainTitle = document.createElement('h1');

function appendMessage(message){
    const paragraphElement = document.createElement('p');
    paragraphElement.innerText = message
    mainTitle.appendChild(paragraphElement)
}
mainTitle.innerText = "SSE Container Initialized"
mainElement.appendChild(mainTitle)

const url = new URL('http://localhost:3000/.well-known/mercure');
url.searchParams.append('topic', 'https://store.com/product-created')
const eventSource = new EventSource(url.toString())

eventSource.onmessage = e => appendMessage(e.data)