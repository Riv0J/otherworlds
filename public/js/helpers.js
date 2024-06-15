async function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
function load_image(url, callback) {
    const img = new Image();
    img.onload = callback;
    img.src = url;
}
function format_number(number) {
    if (number < 1000) {
        return number.toString();
    } else {
        return Math.abs(number) >= 1.0e+9 ? (Math.abs(number) / 1.0e+9).toFixed(1) + 'B' : (Math.abs(number) >= 1.0e+6 ? (Math.abs(number) / 1.0e+6).toFixed(1) + 'M' : (Math.abs(number) >= 1.0e+3 ? (Math.abs(number) / 1.0e+3).toFixed(1) + 'k' : Math.abs(number)));
    }
}

function organize_dic(dic) {
    const organized_dic = {};
    for (let i = 0; i < Object.keys(dic).length; i++) {
        const obj = dic[i];
        organized_dic[obj.id] = obj;
    }
    return organized_dic;
}

function auto_resize(textarea) {
    textarea.style.height = textarea.scrollHeight + 'px';
}

function format_html(html) {
    html = html.replace(/<p>/g, '<p>\n');
    html = html.replace(/<\/p>/g, '\n</p>\n');
    return html.trim();
}

function unformat_html(html) {
    html = html.replace(/<p>\n/g, '<p>');
    html = html.replace(/\n<\/p>\n/g, '</p>');
    html = html.replace(/\n<\/p>/g, '</p>');
    return html.trim();
}
