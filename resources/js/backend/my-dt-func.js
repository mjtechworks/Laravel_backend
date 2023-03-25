function dtBtnView(href, text, attr, target) {
    if(href === undefined) { href = '#' }
    if(text === undefined) { text = 'View' }
    if(attr === undefined) { attr = '' }
    if(target === undefined) { target = '_blank' }

    var btnView = '<a href="'+href+'" class="btn btn-sm btn-primary" target="'+target+'" title="'+text+'" '+attr+'><i class="far fa-eye" aria-hidden="true"></i></a>';
    return btnView;
};

function dtBtnLink(href, text, attr, target) {
    if(href === undefined) { href = '#' }
    if(text === undefined) { text = 'Link' }
    if(attr === undefined) { attr = '' }
    if(target === undefined) { target = '_blank' }

    var btnLink = '<a href="'+href+'" class="btn btn-sm btn-primary" target="'+target+'" title="'+text+'" '+attr+'><i class="fas fa-list" aria-hidden="true"></i></a>';
    return btnLink;
};

function dtBtnEdit(href, text, attr) {
    if(href === undefined) { href = '#' }
    if(text === undefined) { text = 'Edit' }
    if(attr === undefined) { attr = '' }

        var btnEdit = '<a href="'+href+'" class="btn btn-sm btn-warning" title="'+text+'" '+attr+'><i class="fas fa-wrench" aria-hidden="true"></i></a>';
    return btnEdit;
};

function dtBtnDelete(href, text, attr, additionalClass) {
    if(href === undefined) { href = '#' }
    if(text === undefined) { text = 'Delete' }
    if(attr === undefined) { attr = '' }

    var btnDelete = '<a href="'+href+'" class="form-confirm-del btn btn-sm btn-light ml-1 '+additionalClass+'" title="'+text+'" '+attr+'><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
    return btnDelete;
};

function dtTextStatus(text) {
    let status = 'active';
    switch (text) {
        case 'Active':
            status = 'active';
            break;
        case 'Inactive':
            status = 'inactive';
    }
    var spanStatus = '<span class="col-status col-status-'+status+'">'+text+'</span>';
    return spanStatus;
};

function dtHtmlAnchor (href, text, attrClass, attr) {
    if(href === undefined) { href = '#' }
    if(text === undefined) { text = '' }
    if(attrClass === undefined) { attrClass = 'btn btn-primary' }
    if(attr === undefined) { attr = '' }

    var anchorModal = '<a href="'+href+'" class="'+attrClass+'" '+attr+'>'+text+'</a>';
    return anchorModal;
};

function dtConfirmRemoveRow(selector, dt) {
    $(selector).on( 'click', 'a.dt-btn-confirm-remove', function (e) {
        e.preventDefault();

        let $this = $(this),
            confirmText = ($this.data('confirm') === undefined) ? 'Delete This Record?' : $this.data('confirm') ;

        if (confirm(confirmText)) {
            $.ajax({
                url: $this.attr('href'),
                method: 'POST'
            }).done(function(){
                dt.row( $this.parents('tr') )
                .remove()
                .draw();
            }).fail(function(data){
                alert(data);
            });
        }
    });
}