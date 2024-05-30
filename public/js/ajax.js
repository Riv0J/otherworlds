function ajax(ajax_data){
    //ajax_data has request_data which is a dic with the variables to send
    const request_data = ajax_data['request_data'];
    const spinners = document.querySelectorAll('.fa-spinner');
    toggle_spinners(spinners);

    //call before_func, if provided
    if(ajax_data['before_func']){
        ajax_data['before_func']();
    }

    fetch(ajax_data['url'], {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': request_data['_token']
        },
        body: JSON.stringify(request_data),
    })
    // fetch response
    .then(response => {
        // if response is ok (status 200-299)
        if (response.ok) {
            return response.json();
        }
        // error request
        else {
            throw new Error('Error ' + response.statusText);
        }
    })
    // fetch handle data
    .then(response_data => {
        if(ajax_data['success_func']){
            ajax_data['success_func'](response_data);
            if(response_data['message']){
                show_message(response_data['message'])
            }
            if(response_data['messages']){
                response_data['messages'].forEach(function(message){
                    show_message(message)
                });
            }
        }
    })
    // fetch error
    .catch(error => {
        console.error('Request Error:', error);
    })
    // fetch complete
    .finally(() => {
        //call after_func, if provided
        if(ajax_data['after_func']){
            ajax_data['after_func']();
        }
        toggle_spinners(spinners);
    });
}

function toggle_spinners(spinners){
    spinners.forEach(function(spinner){
        if(spinner.style.visibility == "visible"){
            spinner.style.visibility == "hidden"
        } else {
            spinner.style.visibility == "visible"
        }
    });
}
