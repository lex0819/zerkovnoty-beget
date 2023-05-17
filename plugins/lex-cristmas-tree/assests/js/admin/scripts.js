let themePath = '<?= plugins_url(); ?>';
const bannerCurrent = document.querySelector("select[name=banner_lex]");
let bannerImg = document.querySelector('.banner-img');

bannerCurrent.addEventListener('change', function () {
   let newPath = bannerCurrent.value;
   bannerImg.src = themePath + newPath;
});