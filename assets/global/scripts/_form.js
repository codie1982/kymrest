async function sendform(e) {
    e.preventDefault()
    let senddata = [];
    let xhrdata = {};
    var target_form = e.target.attributes.formid.value;
    var form = document.getElementById(target_form)
    var action = form.getAttribute("action");
    if (typeof form.getAttribute("data-send") !== "undefined") {
        if (form.getAttribute("data-send") == "xhr") {
            const datas = form.getElementsByTagName('input');
            for (let i = 0; i < datas.length; i++) {
                let data = datas[i];
                let dataname = data.getAttribute("name");
                let datavalue = data.value;
                senddata[dataname] = datavalue;
            }
        }
    }


    const ndata = "deneme";
    const options = {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, cors, *same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        redirect: 'follow', // manual, *follow, error
        referrer: 'no-referrer', // no-referrer, *client
        headers: {
            'Content-Type': 'application/json',
            //'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: ndata, // body data type must match "Content-Type" header
    }
    const responce = fetch(action, options);
    const json = await responce.then(res => res.json())

    return json
}



