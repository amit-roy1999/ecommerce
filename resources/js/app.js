import 'flowbite';

document.addEventListener('livewire:navigated', () => { initFlowbite(); });
// On page load or when changing themes, best to add inline in `head` to avoid FOUC
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark')
}

console.log('Runs on page one')

// document.addEventListener('alert', function (data) {
//     console.log(data.detail[0].message);
// })
