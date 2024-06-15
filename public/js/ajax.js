function ajax(ajax_data, loading_text){
    //ajax_data has request_data which is a dic with the variables to send
    const request_data = ajax_data['request_data'];
    toggle_spinners(true, loading_text);

    //call before_func, if provided
    if(ajax_data['before_func']){
        ajax_data['before_func']();
    }

    // check if request_data is a FormData instance
    let body;
    let headers = {
        'X-Requested-With': 'XMLHttpRequest'
    };
    if (request_data instanceof FormData) {
        headers['X-CSRF-TOKEN'] = request_data.get('_token'); // Agrega CSRF token al header si es FormData
        body = request_data;
    } else {
        headers['Content-Type'] = 'application/json';
        headers['X-CSRF-TOKEN'] = '_token';
        body = JSON.stringify(request_data);
    }
    console.log(headers);
    // fetch send
    fetch(ajax_data['url'], {
        method: "POST",
        headers: headers,
        body: body,
    })
    // fetch response
    .then(response => {
        // if response is ok (status 200-299)
        if (response.ok) {
            return response.json();
        }
        // error response
        else {
            throw new Error('Error on response ' + response.statusText);
        }
    })
    // fetch handle data
    .then(response_data => {
        if(ajax_data['success_func']){
            ajax_data['success_func'](response_data);
        }
        //show messages, if any
        if(response_data['message']){
            show_message(response_data['message'])
        }
        if(response_data['messages']){
            response_data['messages'].forEach(function(message){
                show_message(message)
            });
        }
    })
    // fetch error
    .catch(error => {
        console.error('AJAX Request Error:', error);
        show_message({type:'danger', icon:'fa-exclamation', text: error});
    })
    // fetch complete
    .finally(() => {
        //call after_func, if provided
        if(ajax_data['after_func']){
            ajax_data['after_func']();
        }
        toggle_spinners(false);
    });
}

function toggle_spinners(show, loading_text){
    const spinners = document.querySelectorAll('.fa-spinner');
    const workings = document.querySelectorAll('.working');

    if(show == false){ sleep(750); }

    spinners.forEach(function(spinner){
        if(show){
            spinner.style.visibility = "visible";
        } else {
            spinner.style.visibility = "hidden";
        }
    });

    workings.forEach(function(working){
        const node = working.querySelector('span');
        if(loading_text){
            node.textContent = loading_text;
        }else{
            node.textContent = "Please wait";
        }
        if(show){
            working.style.visibility = "visible";
        } else {
            working.style.visibility = "hidden";
        }
    });
}
