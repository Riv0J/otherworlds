async function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
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
    console.log(textarea);
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

