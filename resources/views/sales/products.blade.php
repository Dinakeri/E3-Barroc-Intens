<body>
    @include('partials.head')
    <header class="bg-zinc-100 p-6 shadow shadow-gray-500">
        <img src="{{URL::asset('/images/Logo4_klein.png')}}" alt="logo4klein">
    </header>
    <div class="w-[80%] m-auto">
        <main class="flex justify-center col h-[80%] mt-10 text-center">
            <div class="">
                <h1 class="text-2xl">Ondek onze koffiezetapparaten</h1>
                <imageCarousel id="carousel1" class="mt-20">
                    <product class="flex flex-col mt-20 justify-center">
                        <p class="mt-10 text-3xl">Italian Light</p>
                        <img src="{{ URL::asset('/images/products/barrocintens_italian_light.png')}}" alt="image1" id="image1" class="h-[50px] mx-auto">
                    </product>
                </imageCarousel>
            </div>
            <div class="hidden">
                <h1 class="text-2xl">Ondek onze koffiebonen</h1>
                <imageCarousel id="carousel2">
                    <product>
                        <p>Name</p>
                        <img src="" alt="image1" id="image1">
                    </product>
                    <product>
                        <p>Name</p>
                        <img src="" alt="image2" id="image2">
                    </product>
                    <product>
                        <p>Name</p>
                        <img src="" alt="image3" id="image3">
                    </product>
                    <product>
                        <p>Name</p>
                        <img src="" alt="image4" id="image4">
                    </product>
                </imageCarousel>
            </div>
        </main>
        <footer class="row flex justify-between">
            <button id="hidden" class="hidden">Onze koffiezetapparaten</button>
            <a href="{{ url('dashboards.sales') }}">Terug naar sales overzicht</a>
            <button>Onze koffiebonen</button>
        </footer>
    </div>
</body>
