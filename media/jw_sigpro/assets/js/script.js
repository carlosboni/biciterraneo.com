/**
 * @version    3.8.x
 * @package    Simple Image Gallery Pro
 * @author     JoomlaWorks - https://www.joomlaworks.net
 * @copyright  Copyright (c) 2006 - 2020 JoomlaWorks Ltd. All rights reserved.
 * @license    https://www.joomlaworks.net/license
 */

// Joomla Specific
// If we are in Joomla 1.5 define the functions for validation
if (typeof(Joomla) === 'undefined') {
    var Joomla = {};
    Joomla.submitbutton = function(pressbutton) {
        submitform(pressbutton);
    };
    Joomla.submitform = function(pressbutton) {
        submitform(pressbutton);
    };

    function submitbutton(pressbutton) {
        Joomla.submitbutton(pressbutton);
    }
}

function SigProGalleryAction(action) {
    Joomla.submitbutton(action);
    return false;
}

function SigProPagination(limit) {
    document.adminForm.limitstart.value = limit;
    Joomla.submitform();
    return false;
}

(function($) {
    // Cookies
    function createCookie(name, value, days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            var expires = "; expires=" + date.toGMTString();
        } else {
            var expires = "";
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0)
                return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        createCookie(name, "", -1);
    }

    // B/C - Use modal for "add" actions
    Joomla.submitbutton = function(pressbutton) {
        if (pressbutton === 'add') {
            $('#sigProModal').css('margin-left', '-' + ($('#sigProModal').outerWidth()) / 2 + 'px');
            window.scrollTo(0, 0);
            $('#sigProModal').animate({
                'top': '0'
            }, 'fast');
        } else {
            Joomla.submitform(pressbutton);
        }
    };

    /*
    // Open modal function
    window.openModal = function(id) {
        $(id).css('margin-left', '-' + ($(id).outerWidth()) / 2 + 'px');
        window.scrollTo(0, 0);
        $(id).animate({
            'top': '0'
        }, 'fast');
    }
    */

    // Close modal function
    function closeModal() {
        var height = $('#sigProModal').outerHeight() + 200;
        $('#sigProModal').animate({
            'top': '-' + height + 'px'
        }, 'fast');
    }

    // Select K2 item from modal
    window.k2ModalSelector = function(id, name, fid, fname, output) {
        $('input[name=newFolder]').val(id);
        closeModal();
        Joomla.submitform('create');
    }

    // Select K2 item from modal (for K2 v2.8.0 or earlier)
    window.jSelectItem = function(id, title, object) {
        $('input[name=newFolder]').val(id);
        closeModal();
        Joomla.submitform('create');
    }

    // Custom checkboxes
    function setupLabel() {
        // Checkbox variables
        var checkBox = ".sigCheckbox";
        var checkBoxInput = checkBox + " input[type='checkbox']";
        var checkBoxChecked = "sigChecked";
        var checkBoxDisabled = "sigDisabled";

        // Radio variables
        var radio = ".sigRadio";
        var radioInput = radio + " input[type='radio']";
        var radioOn = "sigChecked";
        var radioDisabled = "sigDisabled";

        // Checkboxes
        if ($(checkBoxInput).length) {
            $(checkBox).each(function() {
                $(this).removeClass(checkBoxChecked);
                $(this).parents('.sigProGalleryImage').removeClass('selectedImage');
                $(this).parents('.sigProGallery').removeClass('sigProSelectedGal');
            });
            $(checkBoxInput + ":checked").each(function() {
                $(this).parents(checkBox).addClass(checkBoxChecked);
                $(this).parents('.sigProGalleryImage').toggleClass('selectedImage');
                $(this).parents('.sigProGallery').toggleClass('sigProSelectedGal');
            });
            $(checkBoxInput + ":disabled").each(function() {
                $(this).parents(checkBox).addClass(checkBoxDisabled);
                $(this).parents('.sigProGalleryImage').toggleClass('selectedImage');
                $(this).parents('.sigProGallery').toggleClass('sigProSelectedGal');
            });
        }

        /*
        // Radios
        if ($(radioInput).length) {
            $(radio).each(function() {
                $(this).removeClass(radioOn);
            });
            $(radioInput + ":checked").each(function() {
                $(this).parent(radio).addClass(radioOn);
            });
            $(radioInput + ":disabled").each(function() {
                $(this).parent(radio).addClass(radioDisabled);
            });
        };
        */
    }

    // DOM ready
    $(document).ready(function() {

        // Browser detection
        if ((typeof($.browser) != 'undefined' && $.browser.msie) || (navigator.userAgent.indexOf("MSIE") != -1)) {
            var bodyBrowserClass = 'isIE isIE' + parseInt($.browser.version, 10);
            $('body').addClass(bodyBrowserClass);
        }

        // Set Joomla version as body class
        if ($('#sigPro').hasClass('J15')) { // J1.5
            $('body').addClass('isJVersion15');
        } else if ($('#sigPro').hasClass('J25')) { // J2.5
            $('body').addClass('isJVersion25');
        } else { // J3.x (assume latest)
            $('body').addClass('isJVersion30');
        }

        // Set body class for modals
        if ($('#sigPro').data('sigpro') == 'modal') {
            $('body').addClass('isModal');
        }

        // Append the correct Joomla version on the logo
        if ($('p[align="center"]').length) {
            var JVersionNum = $('#content-box + p[align="center"]').text();
            JVersionNum = JVersionNum.replace("Joomla! ", "");
            $('#border-top .logo').append('<span class="sigJVersionSmall">' + JVersionNum + '</span>');
        }

        // Auto-dismiss system messages after 3 seconds
        window.setTimeout(function() {
            if ($('#system-message').length > 0) {
                $('#system-message').fadeOut();
            }
            if ($('#system-message-container').length > 0) {
                $('#system-message-container').fadeOut();
            }
        }, 3000);

        // Custom checkboxes
        $("#sigPro").on("click", ".sigCheckbox", function() {
            setupLabel();
        });
        setupLabel();

        // Helper classes
        $('table.adminlist tr:even').find('td').addClass('tCellEven');
        $('table.adminlist tr:odd').find('td').addClass('tCellodd');

        $('.sigAnchor').click(function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            var top = $(target).offset().top - 200;
            $('html, body').animate({
                scrollTop: top
            }, 500);
        });

        // Cache selectors
        var lastId,
            topMenu = $(".sigSideNav"),
            topMenuHeight = topMenu.outerHeight() + 15,
            // All list items
            menuItems = topMenu.find("a"),
            // Anchors corresponding to menu items
            scrollItems = menuItems.map(function() {
                var item = $($(this).attr("href"));
                if (item.length) {
                    return item;
                }
            });

        // Bind to scroll
        $(window).scroll(function() {
            // Get container scroll position
            var fromTop = $(this).scrollTop() + topMenuHeight + 100;

            // Get the id of the currently scroll item
            var cur = scrollItems.map(function() {
                if ($(this).offset().top < fromTop)
                    return this;
            });
            // Get the id of the current element
            cur = cur[cur.length - 1];
            var id = cur && cur.length ? cur[0].id : "";

            if (lastId !== id) {
                lastId = id;
                // Set/remove active class
                menuItems.parent().removeClass('active').end().filter('[href="#' + id + '"]').parent().addClass('active');
            }
        });

        // Dynamically attach buttons to system messages
        $('#system-message > dd').append('<span class="sig-icon-cancel-squared sigIconDel" title="Close"><i class="hidden">Close</i></span>');

        // ...same for Joomla 3.x
        $('#system-message-container .alert').append('<span class="sig-icon-cancel-squared sigIconDel" title="Close"><i class="hidden">Close</i></span>');

        $('.sigIconDel').click(function() {
            $(this).parents('dd.message').remove();
            $(this).parents('.alert').remove();
        });

        // if there is more than one message show the mass close button
        if ($('#system-message dd').length > 1) {
            $('#system-message').append('<div class="sigCloseMsg sigTextRight">Close All<span class="sig-icon-cancel-squared sigIconDelAll" title="Close"></span></div>');
            $('.sigIconDelAll').click(function() {
                $('#system-message-container').remove();
            });
        }
        // ...same for Joomla 3.x
        if ($('#system-message-container .alert').length > 1) {
            $('#system-message-container').append('<div class="sigCloseMsg sigTextRight">Close All<span class="sig-icon-cancel-squared sigIconDelAll" title="Close"></span></div>');
            $('.sigIconDelAll').click(function() {
                $('#system-message-container').remove();
            });
        }

        // Prevent form submission using ENTER
        $('#adminForm').bind('keypress', function(event) {
            if (event.keyCode === 13) {
                return false;
            }
        });

        // Selecting Galleries
        $('.sigProGallery input[type="checkbox"]').click(function() {
            $(this).parent().parent().toggleClass('sigProSelectedGal');
        });

        // Multi Select Galleries ( mass Adding/Removing classes)
        $('#sigPro.sigProGalleries #jToggler').click(function() {
            if ($(this).is(':checked')) {
                $('.sigProGallery').removeClass('sigProSelectedGal');
                $('.sigProGallery').addClass('sigProSelectedGal');
                $('.sigCheckbox').removeClass('sigChecked');
                $('.sigCheckbox').addClass('sigChecked');
                $('.sigProGrid').addClass('sigPaddingTop');
            } else {
                $('.sigProGallery').removeClass('sigProSelectedGal');
                $('.sigCheckbox').removeClass('sigChecked');
                $('.sigProGrid').removeClass('sigPaddingTop');
            }
        });

        // Showing the lower area of the toolbar
        $('#sigPro').on("click", 'input[type="checkbox"]', function() {
            var n = $("#sigPro .sigProGridColumn input:checked").length;

            // show/hide the lower toolbar area
            if (n > 0) {
                $('.sigProLowerToolbar').show();
                $('#selectedCount').text(n);
                $('.sigProGrid').addClass('sigPaddingTop');

                // Proper language strings
                if (n === 1) {
                    $('#sigSel1').removeClass('hidden');
                    $('#sigSel2').addClass('hidden');
                } else {
                    $('#sigSel2').removeClass('hidden');
                    $('#sigSel1').addClass('hidden');
                }

                // Force close the sidebar if two or more are selected
                if (n > 1) {
                    if ($('#sigSideBar').hasClass('openSideBar')) {
                        $('#sigSideBar').removeClass('openSideBar');
                        $('.sigProGrid').removeClass('sideBarIsOpen');
                        $('.sigProToolbar').removeClass('sideBarIsOpen');
                    }
                }
            } else { // hide the toolbar if no checkbox is checked
                $('.sigProLowerToolbar').hide();
                $('.sigProGrid').removeClass('sigPaddingTop');
            }
        });

        // Drawer menu
        $('.sideToggler').click(function() {
            $('#sigSideBar').toggleClass('openSideBar');
            $('.sigSlidingItem').toggleClass('sideBarIsOpen');
            return false;
        });

        // AJAX validation when typing folder name
        $('#folder').bind('keyup change', function() {
            if (this.value != this.lastValue) {
                if (this.timer) {
                    clearTimeout(this.timer);
                }
                $('.sigProProceedButton').css('display', 'none');
                $('#sigProValidationStatus').val('');
                $('.sigProValidation').html(SIGProLanguage.checking).removeClass('sigProValidationFail').removeClass('sigProValidationSuccess').addClass('sigProValidationWorking');

                var url = 'index.php?option=com_sigpro&view=gallery&task=validate&type=' + $('input[name=type]').val() + '&folder=' + $(this).val() + '&format=json';

                if (this.value === '') {
                    $('.sigProValidation').html('').removeClass('sigProValidationWorking');
                    return;
                }
                this.timer = setTimeout(function() {
                    $.ajax({
                        url: url,
                        dataType: 'json',
                        type: 'get',
                        success: function(response) {
                            $('.sigProValidation').removeClass('sigProValidationWorking');
                            if (response.status === 1) {
                                $('.sigProValidation').addClass('sigProValidationSuccess');
                                $('.sigProProceedButton').fadeIn('fast');
                            } else {
                                $('.sigProValidation').addClass('sigProValidationFail');
                                $('.sigProProceedButton').css('display', 'none');
                            }
                            $('.sigProValidation').html(response.message);
                            $('#sigProValidationStatus').val(response.status);
                        }
                    });
                }, 500);
                this.lastValue = this.value;
            }
        });

        // Save new folder
        $('.sigProProceedButton').click(function(event) {
            event.preventDefault();
            closeModal();
            Joomla.submitbutton('create');
        });

        // Insert links events (when called by editor)
        var editor = $('input[name=editorName]').val();
        if (editor !== '') {
            $('.sigProInsertButton').click(function(event) {
                event.preventDefault();
                var gallery = $(this).data('path');
                var width = $('input[name=width]').val();
                var height = $('input[name=height]').val();
                var displayMode = $('select[name=displayMode]').val();
                var captionsMode = $('select[name=captionsMode]').val();
                var galleryLayout = $('select[name=galleryLayout]').val();
                var tag;
                if (width || height || displayMode || captionsMode || galleryLayout) {
                    tag = '{gallery}' + gallery + ':' + width + ':' + height + ':' + displayMode + ':' + captionsMode + '::' + galleryLayout + '{/gallery}';
                } else {
                    tag = '{gallery}' + gallery + '{/gallery}';
                }
                parent.jInsertEditorText(tag, editor);
                parent.SigProModalClose();
            });
        }

        // Aspect Ratio (Landscape)
        $('.sigViewLandscape').click(function(event) {
            event.preventDefault();
            $('.sigProGalleryImageLink').removeClass('sigPortrait');
            $('.sigProGalleryPreviewImage').removeClass('sigPortrait');

            // Toggle highlighted button
            $('.sigViewPortrait').removeClass('sigHighlighted');
            $(this).addClass('sigHighlighted');

            eraseCookie('sigRatio');
            createCookie('sigRatio', 'landscape', 30);
        });

        // Aspect Ratio (Portrait)
        $('.sigViewPortrait').click(function(event) {
            event.preventDefault();
            $('.sigProGalleryImageLink').addClass('sigPortrait');
            $('.sigProGalleryPreviewImage').addClass('sigPortrait');

            // Toggle highlighted button
            $('.sigViewLandscape').removeClass('sigHighlighted');
            $(this).addClass('sigHighlighted');

            eraseCookie('sigRatio');
            createCookie('sigRatio', 'portrait', 30);
        });

        // Output the correct ratio
        var ratioCookie = readCookie('sigRatio');
        if (ratioCookie === 'portrait') {
            $('.sigViewPortrait').trigger('click');
        }

        // Close modal event
        $('.sigProModalCloseButton').click(function(event) {
            event.preventDefault();
            closeModal();
        });

        // Gallery view. Uploader, delete and preview gallery image
        if ($("#sigProUploader").length > 0) {

            // Uploader
            var token = $('#adminForm input[type=hidden]:last').attr('name');
            var name = $('#adminForm input[name=folder]').val();
            var type = $('#adminForm input[name=type]').val();
            var iOS = /(iPad|iPhone|iPod)/g.test(navigator.userAgent);

            $("#sigProUploader").pluploadQueue({
                runtimes: 'html5,html4',
                url: 'index.php?option=com_sigpro&view=gallery&task=upload&folder=' + name + '&type=' + type + '&' + token + '=1&format=raw',
                max_file_size: SIGProLanguage.uploadMaxFilesize,
                multiple_queues: true,
                filters: [{
                    title: SIGProLanguage.imgLabel,
                    extensions: 'jpg,jpeg,gif,png'
                }],
                unique_names: iOS,
                init: {
                    UploadComplete: function(uploader, files) {
                        $('.sigProGridColumn').each(function(index) {
                            if (index % 4 === 0) {
                                $(this).addClass('sigProGridFirstColumn');
                            }
                        });
                    },
                    FileUploaded: function(uploader, file, info) {
                        var response = $.parseJSON(info.response);
                        if (typeof response === 'undefined' || response === null) {
                            file.status = plupload.FAILED;
                            file.name = file.name + '<span class="sigProUploadFailed">' + SIGProLanguage.imgUploadFailed + '</span>';
                            uploader.trigger('QueueChanged');
                            return false;
                        }
                        if (response.status === 0) {
                            file.status = plupload.FAILED;
                            file.name = file.name + ' - ' + response.error;
                            uploader.trigger('QueueChanged');
                            return false;
                        }
                        $('#sigPro').removeClass('sigProGalleryEmpty');
                        var element = $('#sigProImageTemplate').clone();
                        element.attr('id', 'sigProImage_' + file.name);
                        element.find('.sigProImageContainer a').attr('href', response.path).attr('title', response.path).addClass('sigProPreviewButton');
                        element.find('.sigProDeleteButton').attr('href', response.name);
                        element.find('.sigProGalleryPreviewImage').css("background-image", "url(" + response.url + ")");
                        element.find('input.sigProFilename').val(response.name);
                        element.find('input[name="image[]"]').val(response.name);
                        element.find('.sigProImageNameValue').html(response.name);
                        element.find('.sigProImageSizeValue').html(response.size);
                        element.find('.sigProImageDimensionsValue').html(response.width + ' x ' + response.height);
                        $('.sigProGrid').append(element);
                        $('a.sigProPreviewButton').unbind('click');
                    }
                }
            });

            // Delete image
            $('#sigPro').on('click', '.sigProDeleteButton', function(event) {
                event.preventDefault();
                var answer = confirm(SIGProLanguage.imgDeleteWarning);
                if (answer) {
                    var container = $(this).parents('.sigProGalleryImage');
                    $('input[name=task]').val('delete');
                    $('input[name=file]').val($(this).attr('href'));
                    var form = $('#adminForm');
                    $.post(form.attr('action'), form.serialize() + '&format=raw', function(response) {
                        $('input[name=file]').val('');
                        if (response.status) {
                            $(container).fadeOut('slow', function() {
                                $(container).remove();
                                $('a.sigProPreviewButton').unbind('click');
                                if ($('.sigProGridColumn').length > 1) {
                                    $('.sigProGridColumn').removeClass('sigProGridFirstColumn');
                                    $('.sigProGridColumn').each(function(index) {
                                        if (index % 4 === 0) {
                                            $(this).addClass('sigProGridFirstColumn');
                                        }
                                    });
                                } else {
                                    $('#sigPro').addClass('sigProGalleryEmpty');
                                }

                            });
                        } else {
                            alert(response.message);
                        }
                    }, 'json');
                }
            });

            // Language for labels
            $('#sigLang').change(function(event) {
                event.preventDefault();
                var url = 'index.php?option=com_sigpro&view=gallery&folder=' + $('input[name=folder]').val() + '&sigLang=' + $(this).val() + '&type=' + $('input[name=type]').val() + '&tmpl=' + $('input[name=tmpl]').val() + '&editorName=' + $('input[name=editorName]').val();
                var template = $('input[name=template]').val();
                if (template) {
                    var redirect = url + '&template=' + template;
                } else {
                    var redirect = url;
                }
                window.location = redirect;
            });
        }
    });
})(jQuery);
