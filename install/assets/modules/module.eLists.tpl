//<?
/**
 * eLists
 * 
 * manage product params lists
 * 
 * @author	    webber (web-ber12@yandex.ru)
 * @category	module
 * @version 	0.1
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal	@guid eFilters
 * @internal    @properties &param_tv_id=ID TV opzioni prodotto;string;44 &product_templates_id=ID template prodotto;string;11 &param_cat_id=ID opzioni di ricerca;string; &exclude_tvs_from_list=Non includere impostazioni TV quando nel output;string; &tovarChunkName=Chunk o Nome del prodotto;string; &pattern_folder=cartella pattern;string;assets/images/pattern/
 * @internal	@modx_category Filters
 * @internal    @installset base, sample
 */
 
 /*
 модуль для управления списками параметров и их значениями, которые можно использовать
 затем для заполнения параметров продуктов и последующей фильтрации
 необходимо включить общие параметры и настроить зависимости для общие: 

  Plugins
tovarParams

  Snippets
eFilter
eFilterResult
multiParams
tovarParams

//аналогично в указанных плагинах и сниппетах импортировать параметры из модуля eLists

 */

require_once MODX_BASE_PATH."assets/modules/eLists/module.eLists.php";
