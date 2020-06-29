function XsdFilter(urlParams) {
    this.urlParams = urlParams;

    this.apply = function () {
        let _thisObj = this
        this.getSort();
        // this.applyFunctions.functionSort(_thisObj)
    }

    this.applyFunctions = {
        //Функция сортировки
        functionSort: function (_thisObj) {
            let sortData = _thisObj.getSort(urlParams)
            if(sortData){
                let sortTitle = sortData.title.replace(/-/g, "")
                let sortHtml = '&#8659;'
                if(sortData.type == 'desc'){
                    sortHtml = '&#8657;'
                }
                $('a[data-name='+sortTitle+']').attr('data-sort-type',sortData.type);
                $('a[data-name='+sortTitle+']').siblings('.html-content').html(sortHtml);
            }
        }
    }


   this.changeTypeSort =  function(typeSort) {
        if(typeSort == 'asc')
            return '-'
        else
            return ''
    }

    this.getUrlParameter = function(sParam) {
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
    this.getUrlVars = function()
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

    this.getSort = function(urlParams) {
        let objSort = {}
        if ('sort' in urlParams && typeof urlParams['sort'] == 'string'){
            objSort.title = urlParams['sort']
            objSort.type = this.getTypeSort(urlParams['sort'])
            return objSort;
        }
        else
            return false
    }

    this.getTypeSort =  function (str) {
        return (str[0] == '-') ? 'desc' : 'asc'
    }

    this.genUrl =  function (except) {
        let pathUrl = window.location.pathname
        let urlParams = this.getUrlVars()
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


}
