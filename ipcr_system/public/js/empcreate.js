let errorMessages = '';
    $("#employee_form").on("submit", function(e) {
        e.preventDefault();
        let formData = new FormData($('#employee_form')[0]);
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/employee/",
                    method: "POST",
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Successfully created a form!',
                                icon: 'success',
                                confirmButtonText: 'Okay'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "/employee/";
                                }
                            })
                        } else {
                            for (let i = 0; i < response.errors.length; i++) {
                                errorMessages += "-" + response.errors[i] + "\n";
                            }
                            Swal.fire({
                                html: '<pre>' + errorMessages + '</pre>',
                                customClass: {
                                    popup: 'format-pre'
                                },
                                title: 'Error!',
                                icon: 'error',
                                confirmButtonText: 'Okay'
                            })
                            errorMessages = "";
                        }
                    }
                });
            } else {
                Swal.fire({
                    title: 'Action cancelled!',
                    text: 'You cancelled the action!',
                    icon: 'info',
                    confirmButtonText: 'Okay'
                })
            }
        });
    });

    var sp = 1;
    $("#addsp").click(function() {
        var sp1 = sp + 1;
        for (sp; sp < sp1; sp++) {
            for (var i = 0; i < sp; i++) {
                if ($('#functions_sp' + sp).val() == null) {
                    $("#strat_table").append('<div class="row addedsp"><div class="form-group col-5"><p for="requested_by" class="form_label"> Strategic Priorities </p><input type="text" id="functions_sp' + sp + '" name="functions_sp' + sp + '" class="form-control"></div><div class="form-group col-5"><p for="requested_by" class="form_label"> Success Indicator </p><input type="text" id="success_indicator_sp' + sp + '" name="success_indicator_sp' + sp + '" class="form-control"></div><div class="form-group col-2"><p> </p><button type="button" class="btn btn-danger" id="removesp"> Remove </button></div></div>');
                }else{
                    for(var sp2 = 1; sp2 < sp; sp2++){
                        if ($('#functions_sp' + sp2).val() == null) {
                            $("#strat_table").append('<div class="row addedsp"><div class="form-group col-5"><p for="requested_by" class="form_label"> Strategic Priorities </p><input type="text" id="functions_sp' + sp2 + '" name="functions_sp' + sp2 + '" class="form-control"></div><div class="form-group col-5"><p for="requested_by" class="form_label"> Success Indicator </p><input type="text" id="success_indicator_sp' + sp2 + '" name="success_indicator_sp' + sp2 + '" class="form-control"></div><div class="form-group col-2"><p> </p><button type="button" class="btn btn-danger" id="removesp"> Remove </button></div></div>');
                            break;
                        }
                    }
                }
                break;
            }
        }
    });
    $(document).on('click', '#removesp', function() {
        $(this).parents('.addedsp').remove();
        --sp;
    });

    var cf = 1;
    $("#addcf").click(function() {
        var cf1 = cf + 1;
        for (cf; cf < cf1; cf++) {
            for (var i = 0; i < cf; i++) {
                if ($('#functions_cf' + cf).val() == null) {
                    $("#core_table").append('<div class="row addedcf"><div class="form-group col-5"><p for="requested_by" class="form_label"> Core Functions </p><input type="text" id="functions_cf' + cf + '" name="functions_cf' + cf + '" class="form-control"></div><div class="form-group col-5"><p for="requested_by" class="form_label"> Success Indicator </p><input type="text" id="success_indicator_cf' + cf + '" name="success_indicator_cf' + cf + '" class="form-control"></div><div class="form-group col-2"><p> </p><button type="button" class="btn btn-danger" id="removecf"> Remove </button></div></div>');
                }else{
                    for(var cf2 = 1; cf2 < cf; cf2++){
                        if ($('#functions_cf' + cf2).val() == null) {
                            $("#core_table").append('<div class="row addedcf"><div class="form-group col-5"><p for="requested_by" class="form_label"> Core Functions </p><input type="text" id="functions_cf' + cf2 + '" name="functions_cf' + cf2 + '" class="form-control"></div><div class="form-group col-5"><p for="requested_by" class="form_label"> Success Indicator </p><input type="text" id="success_indicator_cf' + cf2 + '" name="success_indicator_cf' + cf2 + '" class="form-control"></div><div class="form-group col-2"><p> </p><button type="button" class="btn btn-danger" id="removecf"> Remove </button></div></div>');
                            break;
                        }
                    }
                }
                break;
            }
        }
    });

    $(document).on('click', '#removecf', function() {
        $(this).parents('.addedcf').remove();
        --cf;
    });

    var sf = 1;
    $("#addsf").click(function() {
        var sf1 = sf + 1;
        for (sf; sf < sf1; sf++) {
            for (var i = 0; i < sf; i++) {
                if ($('#functions_sf' + sf).val() == null) {
                    $("#supp_table").append('<div class="row addedsf"><div class="form-group col-5"><p for="requested_by" class="form_label"> Core Functions </p><input type="text" id="functions_sf' + sf + '" name="functions_sf' + sf + '" class="form-control"></div><div class="form-group col-5"><p for="requested_by" class="form_label"> Success Indicator </p><input type="text" id="success_indicator_sf' + sf + '" name="success_indicator_sf' + sf + '" class="form-control"></div><div class="form-group col-2"><p> </p><button type="button" class="btn btn-danger" id="removesf"> Remove </button></div></div>');
                }else{
                    for(var sf2 = 1; sf2 < sf; sf2++){
                        if ($('#functions_sf' + sf2).val() == null) {
                            $("#supp_table").append('<div class="row addedsf"><div class="form-group col-5"><p for="requested_by" class="form_label"> Core Functions </p><input type="text" id="functions_sf' + sf2 + '" name="functions_sf' + sf2 + '" class="form-control"></div><div class="form-group col-5"><p for="requested_by" class="form_label"> Success Indicator </p><input type="text" id="success_indicator_sf' + sf2 + '" name="success_indicator_sf' + sf2 + '" class="form-control"></div><div class="form-group col-2"><p> </p><button type="button" class="btn btn-danger" id="removesf"> Remove </button></div></div>');
                            break;
                        }
                    }
                }
                break;
            }
        }
    });
    $(document).on('click', '#removesf', function() {
        $(this).parents('.addedsf').remove();
        --sf;
    });