//HTTP REQUEST, RETURN ALL OF THE AVALIBLES LOTERRIES
const container = document.getElementById('container-active-loteries');

const getLoteries = async () => {
    try {
        const response = await fetch('https://api-resultadosloterias.com/api/results');
        if (!response.ok) {

            container.innerHTML=`
                <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium"> Lo sentimos!</span> Tenemos problema a la hora de mostrar los resultados, intentalo más tarde.
                </div>
                </div>
            `
        }
        const { data } = await response.json();

        data.forEach(lotery => {
            console.log(lotery);

            container.innerHTML+=`
            <div class="card-lotery">
            <div class="color-card">
            </div>
            <div class="content-card">
                <img src="https://loteriademedellin.com.co/wp-content/uploads/2023/11/logo-loteria-de-medellin-1.png" alt="">
            <h4>${lotery.lottery}</h4>
            <p>Juegó: ${lotery.date}</p>
            <p>Resultado: ${lotery.result}</p>


            </div>
        </div>
            `
            
        });
    } catch (error) {
        console.error('Error:', error);
    }
};

getLoteries();