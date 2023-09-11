// Url js for ajax requests.

const hostname = window.location.hostname;
const tempPort = window.location.port;
let port = '';
if(tempPort != ''){
    port = `:${tempPort}`;
}
const protocol = window.location.protocol
const url = `${protocol}//${hostname}${port}/`;