<body>
    @include('partials.head')
    <header class="bg-zinc-100 p-6 shadow shadow-gray-500">
        <img src="{{URL::asset('/images/Logo4_klein.png')}}" alt="logo4klein">
    </header>
    <div class="w-[80%] m-auto">
        <main class="flex justify-center col h-[80%] mt-10 text-center">
            <div class="flex flex-col w-full items-center"> 
                <h1 class="text-2xl text-center w-full">Ondek onze koffiezetapparaten</h1>
                <imageCarousel id="carousel1" class="mt-20 flex flex-col items-center w-full">
                    <div class="relative w-full mb-4" style="height: 6rem;">
                        <h1 
                            carousel-title 
                            class="absolute left-0 top-[-80px] w-full text-[200px] width: 100%; text-center pointer-events-none select-none" 
                            style="z-index:-1; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; text-shadow: 0 0 25px rgba(255,255,255,0.8), 0 0 50px rgba(255,255,255,0.6);"
                        ></h1>
                    </div>
                    <div class="flex flex-row justify-center items-center w-full">
                        <product class="flex flex-col items-center">
                            <img src="{{ URL::asset('/images/products/barrocintens_italian_light.png')}}" alt="Italian Light" id="image1" class="h-[500px] mx-auto">
                        </product>
                        <product class="flex flex-col items-center">
                            <img src="{{ URL::asset('/images/products/barrocintens_italian.png')}}" alt="Italian" id="image2" class="h-[500px] mx-auto">
                        </product>
                        <product class="flex flex-col items-center">
                            <img src="{{ URL::asset('/images/products/barrocintens_italian_deluxe.png')}}" alt="Italian Deluxe" id="image3" class="h-[500px] mx-auto">
                        </product>
                    </div>
                </imageCarousel>
            </div>
            <div class="pointer-events-none absolute inset-y-0 left-0 right-0 flex items-center justify-between px-4">
                <button type="button" carousel-prev class="pointer-events-auto bg-white/80 hover:bg-white text-gray-800 px-4 py-2 rounded-full shadow transition"><i class="fa-solid fa-arrow-left"></i></button>
                <button type="button" carousel-next class="pointer-events-auto bg-white/80 hover:bg-white text-gray-800 px-4 py-2 rounded-full shadow transition"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
            <div class="hidden">
                <h1 class="text-2xl text-center w-full">Ondek onze koffiebonen</h1>
                <imageCarousel id="carousel2" class="flex flex-col items-center w-full">
                    <product class="flex flex-col items-center">
                        <p>Name</p>
                        <img src="" alt="image1" id="image1">
                    </product>
                    <product class="flex flex-col items-center">
                        <p>Name</p>
                        <img src="" alt="image2" id="image2">
                    </product>

                    <product class="flex flex-col items-center">
                        <p>Name</p>
                        <img src="" alt="image3" id="image3">
                    </product>
                    <product class="flex flex-col items-center">
                        <p>Name</p>
                        <img src="" alt="image4" id="image4">
                    </product>
                </imageCarousel>
            </div>
        </main>
        <footer class="row flex justify-between">
            <button id="hidden" class="hidden">Onze koffiezetapparaten</button>
            <a href="{{ route('dashboards.sales') }}">Terug naar sales overzicht</a>
            <button>Onze koffiebonen</button>
        </footer>
    </div>
</body>
