<body>
    @include('partials.head')
    <header class="bg-zinc-100 p-6 shadow shadow-gray-500">
        <img src="{{URL::asset('/images/Logo4_klein.png')}}" alt="logo4klein">
    </header>
    <div class="w-[80%] m-auto">
        <main class="relative flex justify-center col h-[80%] mt-10 text-center">
            <section id="machines-carousel" data-carousel-section class="w-full hidden">
                <div class="flex flex-col w-full items-center">
                    <h1 class="text-2xl text-center w-full">Ondek onze koffiezetapparaten</h1>
                    <imageCarousel id="carousel-machines" class="mt-20 flex flex-col items-center w-full">
                        <div class="relative w-full mb-4" style="height: 6rem;">
                            <h1 
                                carousel-title 
                                class="absolute left-0 top-[-80px] w-full text-[200px] text-center pointer-events-none select-none" 
                                style="z-index: -1; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; text-shadow: 0 0 25px rgba(255,255,255,0.8), 0 0 50px rgba(255,255,255,0.6);"
                            ></h1>
                        </div>
                        <div class="flex flex-row justify-center items-center w-full">
                            <product class="flex flex-col items-center gap-4">
                                <img src="{{ URL::asset('/images/products/barrocintens_italian_light.png')}}" alt="Italian Light" class="h-[500px] mx-auto">
                            </product>
                            <product class="flex flex-col items-center gap-4">
                                <img src="{{ URL::asset('/images/products/barrocintens_italian.png')}}" alt="Italian" class="h-[500px] mx-auto">
                            </product>
                            <product class="flex flex-col items-center gap-4">
                                <img src="{{ URL::asset('/images/products/barrocintens_italian_deluxe.png')}}" alt="Italian Deluxe" class="h-[500px] mx-auto">
                            </product>
                        </div>
                    </imageCarousel>
                </div>
            </section>

            <section id="beans-carousel" data-carousel-section class="w-full">
                <div class="flex flex-col w-full items-center">
                    <h1 class="text-2xl text-center w-full">Ondek onze koffiebonen</h1>
                    <imageCarousel id="carousel-beans" class="mt-6 flex flex-col items-center w-full">
                        <div class="relative w-full mb-0" style="height: 2rem;">
                            <h1 
                                carousel-title 
                                class="absolute left-0 top-[-70px] w-full text-[200px] text-center pointer-events-none select-none" 
                                style="z-index: -1; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; text-shadow: 0 0 25px rgba(255,255,255,0.8), 0 0 50px rgba(255,255,255,0.6);"
                            ></h1>
                        </div>
                        <div class="flex flex-row justify-center items-center w-full">
                            <product class="flex flex-col items-center gap-4" style="margin-top:45px">
                                <img src="{{ URL::asset('/images/products/barrocintens_crema_beans.png')}}" alt="Crema" class="h-[600px] mx-auto">
                            </product>
                            <product class="flex flex-col items-center gap-4" style="margin-top:45px">
                                <img src="{{ URL::asset('/images/products/barrocintens_aromatica_beans.png')}}" alt="Aromatica" class="h-[600px] mx-auto">
                            </product>
                            <product class="flex flex-col items-center gap-4" style="margin-top:45px">
                                <img src="{{ URL::asset('/images/products/barrocintens_espresso_beans.png')}}" alt="Espresso Roast" class="h-[600px] mx-auto">
                            </product>
                        </div>
                    </imageCarousel>
                </div>
            </section>

            <div class="pointer-events-none absolute inset-y-0 left-0 right-0 flex items-center justify-between px-4">
                <button type="button" carousel-prev class="pointer-events-auto bg-white/80 hover:bg-white text-gray-800 px-4 py-2 rounded-full shadow transition"><i class="fa-solid fa-arrow-left"></i></button>
                <button type="button" carousel-next class="pointer-events-auto bg-white/80 hover:bg-white text-gray-800 px-4 py-2 rounded-full shadow transition"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </main>
        <footer class="row flex justify-between items-center">
            <button data-carousel-toggle="machines-carousel" class="cursor-pointer px-4 py-2 border border-zinc-400 rounded-full text-sm uppercase tracking-wide transition hover:bg-zinc-100 bg-white text-zinc-900">Onze koffiezetapparaten</button>
            <a href="{{ route('dashboards.sales') }}" class="cursor-pointer text-[#fdd716] hover:underline underline-offset-4">Terug naar sales overzicht</a>
            <button data-carousel-toggle="beans-carousel" class="cursor-pointer px-4 py-2 border border-zinc-400 rounded-full text-sm uppercase tracking-wide bg-zinc-900 text-white">Onze koffiebonen</button>
        </footer>
    </div>
</body>
