<?php
	$this->load->helper('url');
?>
<div id="contenu">
	<h2>Liste de mes fiches de frais</h2>
	 	
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
	 
	<table class="listeLegere">
		<thead>
			<tr>
				<th >Nom</th>
				<th >Prenom</th>
				<th >Mois</th>
				<th >Etat</th>  
				<th >Montant</th>  
				<th >Date modif.</th>  
				<th >Motif de refus</th>
				<th  colspan="2">Actions</th>
			</tr>
		</thead>
		<tbody>
          
		<?php    
			foreach( $mesFiches as $uneFiche) 
			{
				if ($uneFiche['id'] == "CL") 
				{
					$accepter= '';
					
					if ($uneFiche['libelle'] == 'Fiche Signée, saisie clôturée') {
						$accepter = anchor('c_comptable/accepterFiche/', 'Accepter',  'title="Modifier la fiche"');
						$refuser = anchor('c_visiteur/modFiche/'.$uneFiche['mois'], 'Refuser',  'title="Modifier la fiche"');
					}	//Si acceptation de la fiche -> traiter la demande
						//Si refus de la fiche -> indiquer motif 
					echo
					'<tr>
					<td class="nom">'.$uneFiche['nom'].'</td>
					<td class="prenom">'.$uneFiche['prenom'].'</td>
					<td class="date">'.anchor('c_visiteur/voirFiche/'.$uneFiche['mois'], $uneFiche['mois'],  'title="Consulter la fiche"').'</td>
					<td class="libelle">'.$uneFiche['libelle'].'</td>
					<td class="montant">'.$uneFiche['montantValide'].'</td>
					<td class="dateModif">'.$uneFiche['dateModif'].'</td>
					<td class="montant"><input type="text" id="txtDateHF" name="dateFrais" size="20" maxlength="20" value=""  /></td>
					<td class="actionAccepter">'.$accepter.'</td>
					<td class="actionRefuser">'.$refuser.'</td>
					</tr>';
				}
				
			}
		?>	  
		</tbody>
    </table>

</div>
