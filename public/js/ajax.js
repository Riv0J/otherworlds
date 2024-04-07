function ajax(ajax_data){
    //ajax_data has request_data which is a dic with the variables to send
    const request_data = ajax_data['request_data'];

    //call before_func, if provided
    if(ajax_data['before_func']){
        ajax_data['before_func']();
    }

    fetch(ajax_data['url'], {
        method: ajax_data['method'],
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
        console.log('Fetch complete.');
    });
}
