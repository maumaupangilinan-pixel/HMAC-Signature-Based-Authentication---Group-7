const apiKey    = 'group7';
const timestamp = '1714000000';
const secret    = '852963';
const payload   = pm.request.body.raw || '';  // use actual body!

const message   = apiKey + timestamp + payload;
const signature = CryptoJS.HmacSHA256(message, secret).toString();

pm.request.headers.add({ key: 'X-API-KEY',   value: apiKey });
pm.request.headers.add({ key: 'X-TIMESTAMP', value: timestamp });
pm.request.headers.add({ key: 'X-SIGNATURE', value: signature });