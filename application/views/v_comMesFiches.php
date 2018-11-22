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
				<th  colspan="4">Actions</th>              
			</tr>
		</thead>
		<tbody>
          
		<?php    
			foreach( $mesFiches as $uneFiche) 
			{
				if ($uneFiche['id'] == "CL") 
				{
					$modLink = '';
					
					if ($uneFiche['libelle'] == 'Fiche Signée, saisie clôturée') {
						$modLink = anchor('c_visiteur/modFiche/'.$uneFiche['mois'], 'Accepter',  'title="Modifier la fiche"');
					}
					
					echo
					'<tr>
					<td class="montant">'.$uneFiche['nom'].'</td>
					<td class="date">'.$uneFiche['prenom'].'</td>
					<td class="date">'.anchor('c_visiteur/voirFiche/'.$uneFiche['mois'], $uneFiche['mois'],  'title="Consulter la fiche"').'</td>
					<td class="libelle">'.$uneFiche['libelle'].'</td>
					<td class="montant">'.$uneFiche['montantValide'].'</td>
					<td class="date">'.$uneFiche['dateModif'].'</td>
					<td class="action">'.$modLink.'</td>
				</tr>';
				}
				

			}
		?>	  
		</tbody>
    </table>

</div>
