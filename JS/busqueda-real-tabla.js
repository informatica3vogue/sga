jQuery('.texto-gris').each(function () {
        var valorActual = jQuery(this).val();

        jQuery(this).focus(function () {
            if (jQuery(this).val() == valorActual) {
                jQuery(this).val('');
                jQuery(this).removeClass('texto-gris');
            }
            ;
        });

        jQuery(this).blur(function () {
            if (jQuery(this).val() == '') {
                jQuery(this).val(valorActual);
                jQuery(this).addClass('texto-gris');
            }
            ;
        });
    });

    jQuery("#buscador").keyup(function () {
        if (jQuery(this).val() != "") {
            jQuery("#tabla tbody>tr").hide();
            jQuery("#tabla td:contiene-palabra('" + jQuery(this).val() + "')").parent("tr").show();
        }
        else {
            jQuery("#tabla tbody>tr").show();
        }
    });

    jQuery.extend(jQuery.expr[":"],
            {
                "contiene-palabra": function (elem, i, match, array) {
                    return (elem.textContent || elem.innerText || jQuery(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
                }
            });