@extends('layouts.front_uni')
@section('titulo', 'Gracias . . .')

@section('style-extra')
    <style>
        .btn-register-uni {
            background-color: #1d314e !important;
            color: white;
            border: solid 0.01px #1d314e;
            font-weight: 700;
            text-align: center;
        }

        .btn-register-uni:hover {
            background-color: #1d314ebc !important;
            color: white;
            border: solid 0.01px #1d314e;
            font-weight: 700;
            text-align: center;
        }

        .text-huge {
            font-size: 28px !important;
            font-weight: 400 !important;
        }

        .text-vhuge {
            font-size: 26px !important;
            font-weight: 400 !important;
        }

        .br-5 {
            border-radius: 10px !important;
        }

        .s-footer p,
        .s-footer a {
            color: white;
            font-size: 13px;
            text-decoration: none;
        }

        .color-n {
            color: #fff;
        }

        .pr-4 {
            padding-right: 2rem;
        }
        .obj-center{
        object-fit: cover;
        object-position: center;
        }
    </style>
@endsection
@section('content')


    <div class="px-2 px-md-5 py-5">
        <div class="row  pt-2 pb-5 px-md-5">
            <section class="col-xs-12 col-lg-6 pb-0 d-none d-lg-block pr-4">
                <img class=" img__Access br-5 obj-center" src="{{ asset('images/universidad/imagen-univ.jpg') }}" width="100%">
            </section>
            <section class="col-xs-12 col-md-10 col-lg-6 px-4 py-4 py-md-0 mx-auto">

                <h1 class="text-huge text-center pb-0">Capacítate con los expertos!</h1>
                <p class="text-left mt-2">
                    UCAL y PLATAFORMA CONSTRUCTIVO firman un convenio para contribuir a la formación complementaria de sus
                    alumnos. Acceso gratuito a más de 195 medios especializados, 215 videos de capacitación y más de 90
                    cursos de especialización con descuentos especiales.
                </p>

                <div class="bg-white br-5">
                    <h3 class="text-vhuge text-center py-3">Completa tu registro</h3>
                    <hr>
                    <div class="pt-0 px-3">
                        @include('web.uni.form_registro', [
                            'universidad' => $active_uni,
                        ])
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection

@section('script-extra')
    <script>
        function fecha_nacimiento(value) {
            var fecha_seleccionada = value;
            var fecha_nacimiento = new Date(fecha_seleccionada);
            var fecha_Actual = new Date();
            var edad = (parseInt((fecha_Actual - fecha_nacimiento) / (1000 * 60 * 60 * 24 * 365)));
            if (edad < 18) {
                document.getElementById("invalid_FN").style.display = "block";
                document.getElementById("invalid_FN").innerHTML = "<strong>La fecha de nacimineto es menor de 18+</strong>";
                document.getElementById("btn_registro").disabled = true;
            } else if (edad > 151) {
                document.getElementById("invalid_FN").style.display = "block";
                document.getElementById("invalid_FN").innerHTML =
                    "<strong>La fecha de nacimineto no puede exeder de 150</strong>";
                document.getElementById("btn_registro").disabled = true;
            } else {
                document.getElementById("invalid_FN").style.display = "none";
                document.getElementById("invalid_FN").innerHTML = " ";
                document.getElementById("btn_registro").disabled = false;
            }
        }
    </script>
@endsection
