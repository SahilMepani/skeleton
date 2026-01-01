import Swiper from 'swiper';
import {
	Navigation,
	Pagination,
	Autoplay,
	Thumbs,
	EffectCreative,
	EffectFade
} from 'swiper/modules';

// Initialize Swiper with modules
Swiper.use([
	Navigation,
	Pagination,
	Autoplay,
	Thumbs,
	EffectCreative,
	EffectFade
]);

// Make Swiper available globally for other scripts
window.Swiper = Swiper;
