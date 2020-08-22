$(function() {

        /**
         * elements from view/xsd/create
         */
    let objCreateComponent = {
            'addedXmlDiv': $('.added-xml-div'),
            'xmlModalButton': $('#xmlModalButton')
        },
        /**
         * elements from view/layouts/modal-add-xml
         */
        modalXmlElem = {
            'modalXml': $('#XmlModal'),
            'createXmlForm': $('#createXmlForm'),
            'xmlField': $('#xml-field')
        },
        formModal = {
            'title': modalXmlElem.createXmlForm.find('input[name=title]'),
            'method': modalXmlElem.createXmlForm.find('input[name=_method]'),
            'baseUrl': modalXmlElem.createXmlForm.attr('action'),
        }


    let myCodeMirror = CodeMirror.fromTextArea(document.getElementById('xml-field'), {
        lineNumbers: true,
        matchBrackets: true,
        autoRefresh: true,
        mode: 'application/xml',
        indentUnit: 4,
        autoCloseTags: true
    });

    objCreateComponent.xmlModalButton.click(function () {
        clearForm()
        setSettingsPost()
    })

    myCodeMirror.refresh()
    $("#createXmlForm").submit(function (event) {
        event.preventDefault(); //prevent default action
        myCodeMirror.setValue(myCodeMirror.getValue().trim())

        let postUrl = $(this).attr("action"), //get form action url
            requestMethod = $(this).attr("method"), //get form GET/POST method
            formData = $(this).serialize(); //Encode form elements for submission

        $.ajax({
            url: postUrl,
            type: requestMethod,
            data: formData,
            complete: function () {

            },
            success: function (data) {
                addXmlForm(data)
            },
            error: function (request, error) {
                alert(request.responseText)
            },
        });
    });

    /**
     * Added id-data  into html-form
     * @param xml
     */
    function addXmlForm(xml) {
        let currentXmlLink = objCreateComponent.addedXmlDiv.find('div.xml-link-div-' + xml.id)
        let htmlData = '<a href="#" class="xml-link" data-id=' + xml.id + ' data-title=' + xml.title + '>' + xml.title + ' <textarea style="display:none;" class="content-xml" type=hidden name=xml-content disabled="disabled" >' + xml.content + '</textarea><input class="id-xml" type=hidden name=xml[] value="' + xml.id + '"></a><button type="button" data-id=' + xml.id + '  class="item btn-sm remove-xml-link" data-toggle="tooltip" data-original-title="Удалить"><i class="fa fa-times"></i></button>'

        if (currentXmlLink.length) {
            currentXmlLink.empty()
            currentXmlLink.append(htmlData)
        } else {
            objCreateComponent.addedXmlDiv.append('<div class="xml-link-div-' + xml.id + '">' + htmlData + '</div>')
        }
        clearForm()
        modalXmlElem.modalXml.modal('toggle')
    }

    objCreateComponent.addedXmlDiv.on("click", "a.xml-link", function (e) {
        e.preventDefault()
        editXml(this)
    });

    objCreateComponent.addedXmlDiv.on("click", "button.remove-xml-link", function (e) {
        objCreateComponent.addedXmlDiv.find('div.xml-link-div-' + $(this).attr('data-id')).remove();
    });
    /**
     * settings form for method PUT (update)
     * @param _this
     */
    function editXml(_this) {
        let idXml = $(_this).attr('data-id')
        let content = $(_this).children(".content-xml").val()
        let title = $(_this).attr('data-title')
        modalXmlElem.modalXml.modal('show');
        formModal.title.val(title)
        formModal.method.val('PUT')
        modalXmlElem.createXmlForm.attr('action', formModal.baseUrl + '/' + idXml);
        myCodeMirror.setValue(content)
    }

    /**
     * settings form for method PUT (create)
     */
    function setSettingsPost() {
        formModal.method.val('POST')
        modalXmlElem.createXmlForm.attr('action', formModal.baseUrl);
    }

    /**
     * just clear
     */
    function clearForm() {
        modalXmlElem.createXmlForm.trigger("reset")
        myCodeMirror.setValue('')
    }
});
