<?php
/**
 * Cette classe correspond à la table "subcommentaires de la BDD.
UN commentaire peut avoir MAXIMUM 2 niveau de Sous Commentaires
 * Code skeleton generated by dia-uml2php5 plugin
 * written by KDO kdo@zpmag.com
 * @see        Commentaire
 */
require_once('Commentaire.php');

class SubComments extends Commentaire {

	/**
	 * Permettra de limiter le niveau de sous commentaires à 3
	 * @var int
	 * @access protected
	 */
	protected  $niveaucom;

	/**
	 * Pour stocker l'identifiant du commentaire "Pere"
	 * @var int
	 * @access protected
	 */
	protected  $comid;


}
?>
