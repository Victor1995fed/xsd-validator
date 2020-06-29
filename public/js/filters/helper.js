function changeTypeSort(typeSort) {
    if(typeSort == 'asc')
        return '-'
    else
        return ''
}

function getUrlParameter(sParam) {
    let sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    let vars = [], hash;
    let hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    if(hashes[0] == window.location.href || hashes[0] == '')
        return []
    for(let i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        // vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return  vars;
}

function getSort(urlParams) {
    let objSort = {}
    if ('sort' in urlParams && typeof urlParams['sort'] == 'string'){
        objSort.title = urlParams['sort']
        objSort.type = getTypeSort(urlParams['sort'])
        return objSort;
    }
    else
        return false
}

function getTypeSort(str) {
    return (str[0] == '-') ? 'desc' : 'asc'
}

//TODO::Переписать все со входом в единственную функцию по генерации url
function genUrl(except) {
    let pathUrl = window.location.pathname
    let urlParams = getUrlVars()
    if(except !== undefined){
        delete urlParams[except];
    }
    for (let prop in urlParams) {
        let first = true
        if(first){
            pathUrl = pathUrl+'?'+prop+'='+urlParams[prop]
        }
        else {
            pathUrl = pathUrl+'&'+prop+'='+urlParams[prop]
        }
        first = false
    }
    return pathUrl
}
