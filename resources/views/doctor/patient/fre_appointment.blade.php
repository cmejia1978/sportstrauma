<div class="remodal" data-remodal-id="add-feedback"
     data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h4><strong>Nueva bitácora</strong></h4>
    <form id="add-feedback-form" role="form">
        {!! csrf_field() !!}
        <input type="hidden" value="{{ $appointment->id }}" name="aid">
        <div class="form-group description-group">
            <label class="control-label" for="input-description">Descripción <span class="required">*</span>
            </label>
            <textarea id="input-description" name="description" class="form-control" cols="30" rows="5"></textarea>
            <span style="display: none;" class="help-block message-description"></span>
        </div>
        <div class="line"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a data-remodal-action="cancel" class="btn btn-primary">Cancelar</a>
                <button type="submit" class="btn btn-success">Agregar</button>
            </div>
        </div>
    </form>
    <div class="loader-backdrop dt-loader" style="display: none;">
        <div data-loader="circle-side"></div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/js/datatables/datatablescm.min.js') }}"></script>
<script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/fuelux/fuelux.js') }}"></script>
<script src="{{ asset('assets/js/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('assets/js/toastr/toastr.min.js') }}"></script>
<script>
    (function(){if(jQuery&&jQuery.fn&&jQuery.fn.select2&&jQuery.fn.select2.amd)var e=jQuery.fn.select2.amd;return e.define("select2/i18n/es",[],function(){return{errorLoading:function(){return"La carga falló"},inputTooLong:function(e){var t=e.input.length-e.maximum,n="Por favor, elimine "+t+" car";return t==1?n+="ácter":n+="acteres",n},inputTooShort:function(e){var t=e.minimum-e.input.length,n="Por favor, introduzca "+t+" car";return t==1?n+="ácter":n+="acteres",n},loadingMore:function(){return"Cargando más resultados…"},maximumSelected:function(e){var t="Sólo puede seleccionar "+e.maximum+" elemento";return e.maximum!=1&&(t+="s"),t},noResults:function(){return"No se encontraron resultados"},searching:function(){return"Buscando…"}}}),{define:e.define,require:e.require}})();
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        toastr.options = {
            showDuration: '300',
            hideDuration: '100',
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
            newestOnTop: true,
            positionClass: 'toast-top-right'
        };


        if ($.fn.select2) {
            $("#input-medicine").select2({language: 'es'});
        }
        var prescriptionsTable,
            filesTable,
            feedbackTable,
            notesTable,
            addPrescriptionModal    = $('[data-remodal-id=add-prescription]').remodal(),
            addPrescriptionForm     = $('#add-prescription-form'),
            updatePrescriptionModal = $('[data-remodal-id=update-prescription]').remodal(),
            updatePrescriptionForm  = $('#update-prescription-form'),
            removePrescriptionModal = $('[data-remodal-id=remove-prescription]').remodal(),
            removePrescriptionForm  = $('#remove-prescription-form'),

            addFileModal            = $('[data-remodal-id=add-file]').remodal(),
            removeFileModal         = $('[data-remodal-id=remove-file]').remodal(),
            removeFileForm          = $('#remove-file-form'),

            addFeedbackModal        = $('[data-remodal-id=add-feedback]').remodal(),
            addFeedbackForm         = $('#add-feedback-form'),
            updateFeedbackModal     = $('[data-remodal-id=update-feedback]').remodal(),
            updateFeedbackForm      = $('#update-feedback-form'),
            removeFeedbackModal     = $('[data-remodal-id=remove-feedback]').remodal(),
            removeFeedbackForm      = $('#remove-feedback-form'),

            addNoteModal            = $('[data-remodal-id=add-note]').remodal(),
            addNoteForm             = $('#add-note-form'),
            updateNoteModal         = $('[data-remodal-id=update-note]').remodal(),
            updateNoteForm          = $('#update-note-form'),
            removeNoteModal         = $('[data-remodal-id=remove-note]').remodal(),
            removeNoteForm          = $('#remove-note-form'),

            loader                  = $('.dt-loader');

        $(document).on('closing', '.remodal', function (e) {
            if (addPrescriptionModal.getState() == 'closing') {
                addPrescriptionForm[0].reset();

                clearPrescriptionFields();
            }

            if (updatePrescriptionModal.getState() == 'closing') {
                updatePrescriptionForm[0].reset();

                clearPrescriptionFields();
            }

            if (addFileModal.getState() == 'closing') {
                Dropzone.forElement("#mediaUploadDZ").removeAllFiles(true);
            }


            if (addFeedbackModal.getState() == 'closing') {
                addFeedbackForm[0].reset();
                $('#add-feedback-form .description-group').removeClass('has-error');
                $('#add-feedback-form .message-description').hide();
            }

            if (updateNoteModal.getState() == 'closing') {
                updateNoteForm[0].reset();
                $('#update-note-form .description-group').removeClass('has-error');
                $('#update-note-form .message-description').hide();
            }

            if (removeNoteModal.getState() == 'closing') {
                removeNoteForm[0].reset();
            }


            if (addNoteModal.getState() == 'closing') {
                addNoteForm[0].reset();
                $('#add-note-form .description-group').removeClass('has-error');
                $('#add-note-form .message-description').hide();
            }

            if (updateNoteModal.getState() == 'closing') {
                updateNoteForm[0].reset();
                $('#update-note-form .description-group').removeClass('has-error');
                $('#update-note-form .message-description').hide();
            }

            if (removeNoteModal.getState() == 'closing') {
                removeNoteForm[0].reset();
            }


            loader.hide();
        });


        /*** notes **/

        $(document).on('click', '.dt-remove-note', function(e) {
            var nid = $(this).data('nid');
            $('#remove-note-nid').val(nid);
        });

        removeNoteForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('notes/remove') !!}',
                method: 'POST',
                data: removeNoteForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        notesTable.ajax.reload();
                        removeNoteForm[0].reset();
                        removeNoteModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('click', '.dt-update-note', function(e) {
            var nid = $(this).data('nid');
            updateNoteForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('notes') !!}/' + nid,
                method: 'GET',
                success: function(res) {
                    updateNoteForm.html(res);
                    loader.fadeOut();
                }
            })
        });

        updateNoteForm.on('submit', function(e) {
            e.preventDefault();

            $('#update-note-form .description-group').removeClass('has-error');
            $('#update-note-form .message-description').hide();
            loader.show();

            $.ajax({
                url: '{!! url('notes/update') !!}',
                data: updateNoteForm.serialize(),
                method: 'POST',
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        notesTable.ajax.reload();
                        updateNoteForm[0].reset();
                        updateNoteModal.close();
                    } else {
                        if (res.error.description) {
                            $('#update-note-form .description-group').addClass('has-error');
                            $('#update-note-form .message-description').html(res.error.description).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });

        });

        addNoteForm.on('submit', function(e){
            e.preventDefault();

            $('#add-note-form .description-group').removeClass('has-error');
            $('#add-note-form .message-description').hide();
            loader.show();

            $.ajax({
                url: '{!! url('notes/add') !!}',
                data: addNoteForm.serialize(),
                method: 'POST',
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        notesTable.order( [ 0, 'desc' ] ).draw();
                        addNoteForm[0].reset();
                        addNoteModal.close();
                    } else {
                        if (res.error.description) {
                            $('#add-note-form .description-group').addClass('has-error');
                            $('#add-note-form .message-description').html(res.error.description).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });
        });


        notesTable = $('#notes-table').DataTable({
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: '{!! url('notes-data', $appointment->id) !!}',
            dom:
            "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                { text: 'Nuevo', action: function ( e, dt, node, config ) { addNoteModal.open(); } },
                'pageLength'
            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'description', name: 'description'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });

        /*** feedback **/

        $(document).on('click', '.dt-remove-feedback', function(e) {
            var fid = $(this).data('fid');
            $('#remove-feedback-fid').val(fid);
        });

        removeFeedbackForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('feedback/remove') !!}',
                method: 'POST',
                data: removeFeedbackForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        feedbackTable.ajax.reload();
                        removeFeedbackForm[0].reset();
                        removeFeedbackModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('click', '.dt-update-feedback', function(e) {
            var fid = $(this).data('fid');
            updateFeedbackForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('feedback') !!}/' + fid,
                method: 'GET',
                success: function(res) {
                    updateFeedbackForm.html(res);
                    loader.fadeOut();
                }
            })
        });

        updateFeedbackForm.on('submit', function(e) {
            e.preventDefault();

            $('#update-feedback-form .description-group').removeClass('has-error');
            $('#update-feedback-form .message-description').hide();
            loader.show();

            $.ajax({
                url: '{!! url('feedback/update') !!}',
                data: updateFeedbackForm.serialize(),
                method: 'POST',
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        feedbackTable.ajax.reload();
                        updateFeedbackForm[0].reset();
                        updateFeedbackModal.close();
                    } else {
                        if (res.error.description) {
                            $('#update-feedback-form .description-group').addClass('has-error');
                            $('#update-feedback-form .message-description').html(res.error.description).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });

        });

        addFeedbackForm.on('submit', function(e){
            e.preventDefault();

            $('#add-feedback-form .description-group').removeClass('has-error');
            $('#add-feedback-form .message-description').hide();
            loader.show();

            $.ajax({
                url: '{!! url('feedback/add') !!}',
                data: addFeedbackForm.serialize(),
                method: 'POST',
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        feedbackTable.order( [ 0, 'desc' ] ).draw();
                        addFeedbackForm[0].reset();
                        addFeedbackModal.close();
                    } else {
                        if (res.error.description) {
                            $('#add-feedback-form .description-group').addClass('has-error');
                            $('#add-feedback-form .message-description').html(res.error.description).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });
        });


        feedbackTable = $('#feedback-table').DataTable({
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: '{!! url('feedback-data', $appointment->id) !!}',
            dom:
            "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                { text: 'Nuevo', action: function ( e, dt, node, config ) { addFeedbackModal.open(); } },
                'pageLength'
            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'description', name: 'description'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });



        /*** files **/

        $(document).on('click', '.dt-remove-file', function(e) {
            var fid = $(this).data('fid');
            $('#remove-fid').val(fid);
        });

        removeFileForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('media/delete') !!}',
                method: 'POST',
                data: removeFileForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        filesTable.order( [ 0, 'desc' ] ).draw();
                        removeFileForm[0].reset();
                        removeFileModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('closing', '.remodal', function (e) {
            if (addFileModal.getState() == 'closing') {
                Dropzone.forElement("#mediaUploadDZ").removeAllFiles(true);
            }

            loader.hide();
        });

        Dropzone.options.mediaUploadDZ = {
            paramName: 'file',
            maxFilesize: 50, // MB,
            acceptedFiles: 'image/jpeg, image/png, video/*, audio/*, .txt, .doc, .docx',
            init: function(e) {
                this.on('error', function(file, res) {
                    $(file.previewElement).find('.dz-error-message').text(res.error);
                });
            },
            queuecomplete: function(file) {
                filesTable.order( [ 0, 'desc' ] ).draw();
            }
        };

        filesTable = $('#files-table').DataTable({
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: '{!! url('media-appointment-data', $appointment->id) !!}',
            dom:
            "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                { text: 'Agregar archivo(s)', action: function ( e, dt, node, config ) { addFileModal.open(); } },
                'pageLength'
            ],

            columns: [
                {data: 'id', name: 'id'},
                {data: 'original_filename', name: 'original_filename'},
                {data: 'mime', name: 'mime'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });


        // **** prescriptions **//
        function clearPrescriptionFields() {
            $('#add-prescription-form .medicine-group').removeClass('has-error');
            $('#add-prescription-form .message-medicine').hide();
            $('#add-prescription-form .indication-group').removeClass('has-error');
            $('#add-prescription-form .message-indication').hide();

            $('#update-prescription-form .medicine-group').removeClass('has-error');
            $('#update-prescription-form .message-medicine').hide();
            $('#update-prescription-form .indication-group').removeClass('has-error');
            $('#update-prescription-form .message-indication').hide();
        }


        removePrescriptionForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('prescriptions/remove') !!}',
                method: 'POST',
                data: removePrescriptionForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        prescriptionsTable.ajax.reload();
                        removePrescriptionForm[0].reset();
                        removePrescriptionModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('click', '.dt-remove-prescription', function(e) {
            var psid = $(this).data('psid');
            $('#remove-psid').val(psid);
        });

        updatePrescriptionForm.on('submit', function(e) {
            e.preventDefault();

            clearPrescriptionFields();
            loader.show();

            $.ajax({
                url: '{{ url('prescriptions/update') }}',
                method: 'POST',
                data: updatePrescriptionForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        prescriptionsTable.ajax.reload();
                        updatePrescriptionForm[0].reset();
                        updatePrescriptionModal.close();
                    } else {

                        if (res.error.medicine) {
                            $('#update-prescription-form .medicine-group').addClass('has-error');
                            $('#update-prescription-form .message-medicine').html(res.error.medicine).fadeIn();
                        }

                        if (res.error.indication) {
                            $('#update-prescription-form .indication-group').addClass('has-error');
                            $('#update-prescription-form .message-indication').html(res.error.indication).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            })
        });

        $(document).on('click', '.dt-update-prescription', function(e) {
            var psid = $(this).data('psid');
            updatePrescriptionForm.html('');

            loader.show();
            $.ajax({
                url: '{!! url('prescriptions/info') !!}/' + psid,
                method: 'GET',
                success: function(res) {
                    updatePrescriptionForm.html(res.info);
                    if ($.fn.select2) { $("#input-update-medicine").select2({language: 'es'}); }
                    $("#input-update-medicine").val(res.prescription.medicine_id).trigger("change");
                    loader.fadeOut();
                }
            })
        });

        addPrescriptionForm.on('submit', function(e) {
            e.preventDefault();

            clearPrescriptionFields();
            loader.show();

            $.ajax({
                url: '{{ url('prescriptions/add') }}',
                method: 'POST',
                data: addPrescriptionForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        prescriptionsTable.order( [ 0, 'desc' ] ).draw();
                        addPrescriptionForm[0].reset();
                        addPrescriptionModal.close();
                    } else {
                        if (res.error.medicine) {
                            $('#add-prescription-form .medicine-group').addClass('has-error');
                            $('#add-prescription-form .message-medicine').html(res.error.medicine).fadeIn();
                        }

                        if (res.error.indication) {
                            $('#add-prescription-form .indication-group').addClass('has-error');
                            $('#add-prescription-form .message-indication').html(res.error.indication).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            })
        });


        prescriptionsTable = $('#prescriptions-table').DataTable({
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: '{!! url('prescriptions-data', $appointment->id   ) !!}',
            dom:
            "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                { text: 'Agregar a receta', action: function ( e, dt, node, config ) { addPrescriptionModal.open(); } },
                { text: 'Exportar a pdf', action: function ( e, dt, node, config ) { window.location.href = '{{ url('prescriptions/pdf/download', $appointment->id) }}'; } },
                { text: 'Exportar a pdf y ver', action: function ( e, dt, node, config ) { window.open('{{ url('prescriptions/pdf/view', $appointment->id) }}', '_blank'); } },
                { text: 'Enviar pdf al paciente',
                    action: function ( e, dt, node, config ) {
                        $.ajax({
                            url: '{{ url('prescriptions/pdf/send') }}',
                            data: { aid: '{{ $appointment->id }}'},
                            method: 'POST',
                            success: function(res) {
                                if (res.success) {
                                    toastr.success('El correo ha sido enviado');
                                } else {
                                    toastr.error('Error al enviar el correo');
                                }
                            }
                        });
                    }},
                'pageLength'
            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'medicine_id', name: 'medicine_id'},
                {data: 'indication', name: 'indication'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });
    });
</script>
@endpush
