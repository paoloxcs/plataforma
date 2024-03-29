@component('mail::message') 
<style>
    /* CONFIG STYLES Please do not delete and edit CSS styles below */
    /* IMPORTANT THIS STYLES MUST BE ON FINAL EMAIL */
    .rollover div {
        font-size: 0;
    }

    .rollover:hover .rollover-first {
        max-height: 0px !important;
        display: none !important;
    }

    .rollover:hover .rollover-second {
        max-height: none !important;
        display: block !important;
    }

    .container-hover:hover>table {
        background: linear-gradient(153.06deg, #7EE8FA -0.31%, #EEC0C6 99.69%) !important;
        transition: 0.3s all !important;
    }

    .es-menu.es-table-not-adapt td a:hover,
    a.es-button:hover {
        text-decoration: underline !important;
    }

    #outlook a {
        padding: 0;
    }

    .es-button {
        mso-style-priority: 100 !important;
        text-decoration: none !important;
    }

    a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
    }

    .es-desk-hidden {
        display: none;
        float: left;
        overflow: hidden;
        width: 0;
        max-height: 0;
        line-height: 0;
        mso-hide: all;
    }

    [data-ogsb] .es-button {
        border-width: 0 !important;
        padding: 15px 30px 15px 30px !important;
    }

    /*
    END OF IMPORTANT
    */
    body {
        width: 100%;
        font-family: arial, 'helvetica neue', helvetica, sans-serif;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
    }

    table {
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        border-collapse: collapse;
        border-spacing: 0px;
    }

    table td,
    body,
    .es-wrapper {
        padding: 0;
        Margin: 0;
    }

    .es-content,
    .es-header,
    .es-footer {
        table-layout: fixed !important;
        width: 100%;
    }

    img {
        display: block;
        border: 0;
        outline: none;
        text-decoration: none;
        -ms-interpolation-mode: bicubic;
    }

    p,
    hr {
        Margin: 0;
    }

    h1,
    h2,
    h3,
    h4,
    h5 {
        Margin: 0;
        line-height: 120%;
        mso-line-height-rule: exactly;
        font-family: 'Exo 2', sans-serif;
    }

    p,
    ul li,
    ol li,
    a {
        -webkit-text-size-adjust: none;
        -ms-text-size-adjust: none;
        mso-line-height-rule: exactly;
    }

    .es-left {
        float: left;
    }

    .es-right {
        float: right;
    }

    .es-p5 {
        padding: 5px;
    }

    .es-p5t {
        padding-top: 5px;
    }

    .es-p5b {
        padding-bottom: 5px;
    }

    .es-p5l {
        padding-left: 5px;
    }

    .es-p5r {
        padding-right: 5px;
    }

    .es-p10 {
        padding: 10px;
    }

    .es-p10t {
        padding-top: 10px;
    }

    .es-p10b {
        padding-bottom: 10px;
    }

    .es-p10l {
        padding-left: 10px;
    }

    .es-p10r {
        padding-right: 10px;
    }

    .es-p15 {
        padding: 15px;
    }

    .es-p15t {
        padding-top: 15px;
    }

    .es-p15b {
        padding-bottom: 15px;
    }

    .es-p15l {
        padding-left: 15px;
    }

    .es-p15r {
        padding-right: 15px;
    }

    .es-p20 {
        padding: 20px;
    }

    .es-p20t {
        padding-top: 20px;
    }

    .es-p20b {
        padding-bottom: 20px;
    }

    .es-p20l {
        padding-left: 20px;
    }

    .es-p20r {
        padding-right: 20px;
    }

    .es-p25 {
        padding: 25px;
    }

    .es-p25t {
        padding-top: 25px;
    }

    .es-p25b {
        padding-bottom: 25px;
    }

    .es-p25l {
        padding-left: 25px;
    }

    .es-p25r {
        padding-right: 25px;
    }

    .es-p30 {
        padding: 30px;
    }

    .es-p30t {
        padding-top: 30px;
    }

    .es-p30b {
        padding-bottom: 30px;
    }

    .es-p30l {
        padding-left: 30px;
    }

    .es-p30r {
        padding-right: 30px;
    }

    .es-p35 {
        padding: 35px;
    }

    .es-p35t {
        padding-top: 35px;
    }

    .es-p35b {
        padding-bottom: 35px;
    }

    .es-p35l {
        padding-left: 35px;
    }

    .es-p35r {
        padding-right: 35px;
    }

    .es-p40 {
        padding: 40px;
    }

    .es-p40t {
        padding-top: 40px;
    }

    .es-p40b {
        padding-bottom: 40px;
    }

    .es-p40l {
        padding-left: 40px;
    }

    .es-p40r {
        padding-right: 40px;
    }

    .es-menu td {
        border: 0;
    }

    .es-menu td a img {
        display: inline-block !important;
        vertical-align: middle;
    }

    /*
    END CONFIG STYLES
    */
    s {
        text-decoration: line-through;
    }

    p,
    ul li,
    ol li {
        font-family: 'Exo 2', sans-serif;
        line-height: 150%;
    }

    ul li,
    ol li {
        Margin-bottom: 15px;
        margin-left: 0;
    }

    a:hover {
        text-decoration: underline;
    }

    .es-menu td a {
        text-decoration: none;
        display: block;
        font-family: 'Exo 2', sans-serif;
    }

    .es-wrapper {
        width: 100%;
        height: 100%;
        background-repeat: no-repeat;
        background-position: center top;
    }

    .es-wrapper-color,
    .es-wrapper {
        background-color: #e7e3e3;
    }

    .es-header {
        background-color: transparent;
        background-image: ;
        background-repeat: repeat;
        background-position: center top;
    }

    .es-header-body {
        background-color: transparent;
    }

    .es-header-body p,
    .es-header-body ul li,
    .es-header-body ol li {
        color: #dddddd;
        font-size: 18px;
    }

    .es-header-body a {
        color: #000000;
        font-size: 18px;
    }

    .es-content-body {
        background-color: transparent;
    }

    .es-content-body p,
    .es-content-body ul li,
    .es-content-body ol li {
        color: #666666;
        font-size: 18px;
    }

    .es-content-body a {
        color: #391484;
        font-size: 18px;
    }

    .es-footer {
        background-color: transparent;
        background-image: ;
        background-repeat: repeat;
        background-position: center top;
    }

    .es-footer-body {
        background-color: transparent;
    }

    .es-footer-body p,
    .es-footer-body ul li,
    .es-footer-body ol li {
        color: #666666;
        font-size: 16px;
    }

    .es-footer-body a {
        color: #391484;
        font-size: 16px;
    }

    .es-infoblock,
    .es-infoblock p,
    .es-infoblock ul li,
    .es-infoblock ol li {
        line-height: 120%;
        font-size: 12px;
        color: #cccccc;
    }

    .es-infoblock a {
        font-size: 12px;
        color: #cccccc;
    }

    h1 {
        font-size: 36px;
        font-style: normal;
        font-weight: bold;
        color: #000000;
    }

    h2 {
        font-size: 28px;
        font-style: normal;
        font-weight: bold;
        color: #000000;
    }

    h3 {
        font-size: 20px;
        font-style: normal;
        font-weight: normal;
        color: #000000;
    }

    .es-header-body h1 a,
    .es-content-body h1 a,
    .es-footer-body h1 a {
        font-size: 36px;
    }

    .es-header-body h2 a,
    .es-content-body h2 a,
    .es-footer-body h2 a {
        font-size: 28px;
    }

    .es-header-body h3 a,
    .es-content-body h3 a,
    .es-footer-body h3 a {
        font-size: 20px;
    }

    a.es-button,
    button.es-button {
        border-style: solid;
        border-color: #ffdda9;
        border-width: 15px 30px 15px 30px;
        display: inline-block;
        background: #ffdda9;
        border-radius: 30px;
        font-size: 20px;
        font-family: 'Exo 2', sans-serif;
        font-weight: normal;
        font-style: normal;
        line-height: 120%;
        color: #000000;
        text-decoration: none;
        width: auto;
        text-align: center;
    }

    .es-button-border {
        border-style: solid solid solid solid;
        border-color: #ffdda9 #ffdda9 #ffdda9 #ffdda9;
        background: #ffdda9;
        border-width: 0px 0px 2px 0px;
        display: inline-block;
        border-radius: 30px;
        width: auto;
    }

    .msohide {
        mso-hide: all;
    }

    /* RESPONSIVE STYLES Please do not delete and edit CSS styles below. If you don't need responsive layout, please delete this section. */
    @media only screen and (max-width: 600px) {

        p,
        ul li,
        ol li,
        a {
            line-height: 150% !important;
        }

        h1,
        h2,
        h3,
        h1 a,
        h2 a,
        h3 a {
            line-height: 120% !important;
        }

        h1 {
            font-size: 28px !important;
            text-align: left;
        }

        h2 {
            font-size: 24px !important;
            text-align: left;
        }

        h3 {
            font-size: 20px !important;
            text-align: left;
        }

        .es-header-body h1 a,
        .es-content-body h1 a,
        .es-footer-body h1 a {
            font-size: 28px !important;
            text-align: left;
        }

        .es-header-body h2 a,
        .es-content-body h2 a,
        .es-footer-body h2 a {
            font-size: 24px !important;
            text-align: left;
        }

        .es-header-body h3 a,
        .es-content-body h3 a,
        .es-footer-body h3 a {
            font-size: 20px !important;
            text-align: left;
        }

        .es-menu td a {
            font-size: 16px !important;
        }

        .es-header-body p,
        .es-header-body ul li,
        .es-header-body ol li,
        .es-header-body a {
            font-size: 16px !important;
        }

        .es-content-body p,
        .es-content-body ul li,
        .es-content-body ol li,
        .es-content-body a {
            font-size: 16px !important;
        }

        .es-footer-body p,
        .es-footer-body ul li,
        .es-footer-body ol li,
        .es-footer-body a {
            font-size: 16px !important;
        }

        .es-infoblock p,
        .es-infoblock ul li,
        .es-infoblock ol li,
        .es-infoblock a {
            font-size: 12px !important;
        }

        *[class="gmail-fix"] {
            display: none !important;
        }

        .es-m-txt-c,
        .es-m-txt-c h1,
        .es-m-txt-c h2,
        .es-m-txt-c h3 {
            text-align: center !important;
        }

        .es-m-txt-r,
        .es-m-txt-r h1,
        .es-m-txt-r h2,
        .es-m-txt-r h3 {
            text-align: right !important;
        }

        .es-m-txt-l,
        .es-m-txt-l h1,
        .es-m-txt-l h2,
        .es-m-txt-l h3 {
            text-align: left !important;
        }

        .es-m-txt-r img,
        .es-m-txt-c img,
        .es-m-txt-l img {
            display: inline !important;
        }

        .es-button-border {
            display: inline-block !important;
        }

        a.es-button,
        button.es-button {
            font-size: 20px !important;
            display: inline-block !important;
        }

        .es-adaptive table,
        .es-left,
        .es-right {
            width: 100% !important;
        }

        .es-content table,
        .es-header table,
        .es-footer table,
        .es-content,
        .es-footer,
        .es-header {
            width: 100% !important;
            max-width: 600px !important;
        }

        .es-adapt-td {
            display: block !important;
            width: 100% !important;
        }

        .adapt-img {
            width: 100% !important;
            height: auto !important;
        }

        .es-m-p0 {
            padding: 0 !important;
        }

        .es-m-p0r {
            padding-right: 0 !important;
        }

        .es-m-p0l {
            padding-left: 0 !important;
        }

        .es-m-p0t {
            padding-top: 0 !important;
        }

        .es-m-p0b {
            padding-bottom: 0 !important;
        }

        .es-m-p20b {
            padding-bottom: 20px !important;
        }

        .es-mobile-hidden,
        .es-hidden {
            display: none !important;
        }

        tr.es-desk-hidden,
        td.es-desk-hidden,
        table.es-desk-hidden {
            width: auto !important;
            overflow: visible !important;
            float: none !important;
            max-height: inherit !important;
            line-height: inherit !important;
        }

        tr.es-desk-hidden {
            display: table-row !important;
        }

        table.es-desk-hidden {
            display: table !important;
        }

        td.es-desk-menu-hidden {
            display: table-cell !important;
        }

        .es-menu td {
            width: 1% !important;
        }

        table.es-table-not-adapt,
        .esd-block-html table {
            width: auto !important;
        }

        table.es-social {
            display: inline-block !important;
        }

        table.es-social td {
            display: inline-block !important;
        }

        .es-m-p5 {
            padding: 5px !important;
        }

        .es-m-p5t {
            padding-top: 5px !important;
        }

        .es-m-p5b {
            padding-bottom: 5px !important;
        }

        .es-m-p5r {
            padding-right: 5px !important;
        }

        .es-m-p5l {
            padding-left: 5px !important;
        }

        .es-m-p10 {
            padding: 10px !important;
        }

        .es-m-p10t {
            padding-top: 10px !important;
        }

        .es-m-p10b {
            padding-bottom: 10px !important;
        }

        .es-m-p10r {
            padding-right: 10px !important;
        }

        .es-m-p10l {
            padding-left: 10px !important;
        }

        .es-m-p15 {
            padding: 15px !important;
        }

        .es-m-p15t {
            padding-top: 15px !important;
        }

        .es-m-p15b {
            padding-bottom: 15px !important;
        }

        .es-m-p15r {
            padding-right: 15px !important;
        }

        .es-m-p15l {
            padding-left: 15px !important;
        }

        .es-m-p20 {
            padding: 20px !important;
        }

        .es-m-p20t {
            padding-top: 20px !important;
        }

        .es-m-p20r {
            padding-right: 20px !important;
        }

        .es-m-p20l {
            padding-left: 20px !important;
        }

        .es-m-p25 {
            padding: 25px !important;
        }

        .es-m-p25t {
            padding-top: 25px !important;
        }

        .es-m-p25b {
            padding-bottom: 25px !important;
        }

        .es-m-p25r {
            padding-right: 25px !important;
        }

        .es-m-p25l {
            padding-left: 25px !important;
        }

        .es-m-p30 {
            padding: 30px !important;
        }

        .es-m-p30t {
            padding-top: 30px !important;
        }

        .es-m-p30b {
            padding-bottom: 30px !important;
        }

        .es-m-p30r {
            padding-right: 30px !important;
        }

        .es-m-p30l {
            padding-left: 30px !important;
        }

        .es-m-p35 {
            padding: 35px !important;
        }

        .es-m-p35t {
            padding-top: 35px !important;
        }

        .es-m-p35b {
            padding-bottom: 35px !important;
        }

        .es-m-p35r {
            padding-right: 35px !important;
        }

        .es-m-p35l {
            padding-left: 35px !important;
        }

        .es-m-p40 {
            padding: 40px !important;
        }

        .es-m-p40t {
            padding-top: 40px !important;
        }

        .es-m-p40b {
            padding-bottom: 40px !important;
        }

        .es-m-p40r {
            padding-right: 40px !important;
        }

        .es-m-p40l {
            padding-left: 40px !important;
        }

        .m-c-p16r {
            padding-right: 8vw;
        }

        .es-desk-hidden {
            display: table-row !important;
            width: auto !important;
            overflow: visible !important;
            max-height: inherit !important;
        }

        .h-auto {
            height: auto !important;
        }
    }

    /* END RESPONSIVE STYLES */
    .es-p-default {
        padding-top: 40px;
        padding-right: 40px;
        padding-bottom: 40px;
        padding-left: 40px;
    }

    .es-p-all-default {
        padding: 40px;
    }

    html,
    body {
        font-family: 'Exo 2', sans-serif;
    }
</style>
<table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="background-position: center top;">
    <tbody>
        <tr>
            <td class="esd-email-paddings" valign="top">
                <table cellpadding="0" cellspacing="0" class="es-content esd-header-popover" align="center">
                    <tbody>
                        <tr>
                            <td class="esd-stripe es-m-p15r es-m-p15l" align="center">
                                <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="640" style="background-color: #f5f8fa;" bgcolor="#f5f8fa">
                                    <tbody>
                                        <tr>
                                            <td class="esd-structure es-p30t es-p40b es-p40r es-p40l es-m-p20" align="left" bgcolor="#ffffff" style="background-color: #ffffff; border-radius: 20px 20px 0px 0px;">
                                                <table cellpadding="0" cellspacing="0" width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td width="560" align="left" class="esd-container-frame">
                                                                <table cellpadding="0" cellspacing="0" width="100%">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="left" class="esd-block-text es-p30t">
                                                                                <p><strong>
                                                                                    ¡Hola Plataforma Constructiva! 
                                                                                    </strong><br><br>
                                                                                    Mi nombre es <strong>{{$data['name']}}</strong>, estoy interesado en este curso.
                                                                                    <br><br>
                                                                                    {{-- Recientemente, realizó una promoción junto con nuestros socios, por lo que hemos preparado ofertas para productos electrónicos con descuentos de hasta el 80 % --}}
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center" class="esd-block-spacer es-p20" style="font-size:0">
                                                                                <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="border-bottom: 1px solid #cccccc; background: unset; height:1px; width:100%; margin:0px 0px 0px 0px;"></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="left" class="esd-block-text es-p10r es-p10l">
                                                                                <p style="color: #060606; text-align: center;">
                                                                                    <u><strong>
                                                                                        Datos
                                                                                    </strong></u>
                                                                                </p>
                                                                                <ul>
                                                                                    <li style="color: #060606;">
                                                                                        <p><strong>
                                                                                            Nombre:
                                                                                            </strong>
                                                                                            {{$data['name']}}
                                                                                        </p>
                                                                                    </li>
                                                                                    <li style="color: #060606;">
                                                                                        <p><strong>
                                                                                            Correo:
                                                                                            </strong>
                                                                                            {{$data['email']}}
                                                                                        </p>
                                                                                    </li>
                                                                                    <li style="color: #060606;">
                                                                                        <p><strong>
                                                                                            Telf / Móvil:
                                                                                            </strong>
                                                                                            {{$data['phone']}}
                                                                                        </p>
                                                                                    </li>
                                                                                    <li style="color: #060606;">
                                                                                        <p><strong>
                                                                                            Curso:
                                                                                            </strong>
                                                                                            {{$data['curso']}}
                                                                                        </p>
                                                                                    </li>

                                                                                </ul>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center" class="esd-block-spacer es-p20" style="font-size:0">
                                                                                <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="border-bottom: 1px solid #cccccc; background: unset; height:1px; width:100%; margin:0px 0px 0px 0px;">
                                                                                             
                                                                                                @component('mail::button', ['url' => 'http://plataforma.constructivo.com/curso/'.$data['slug'].''])
                                                                                                Ver curso ahora
                                                                                                @endcomponent
    
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr> 
                                                                        <tr>
                                                                            <td align="left" class="esd-block-text">
                                                                                <p> <>
                                                                                    Saludos, {{$data['name']}}
                                                                                    </strong> 
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table> 
            </td>
        </tr>
    </tbody>
</table> 
@endcomponent