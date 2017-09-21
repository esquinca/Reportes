<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class TicketsController extends Controller
{
    public function historicTickets()
    {
    	//187.190.55.27 
    	#pruebas...
    	//dd($data['previous_page']);
		//$variable = $response->results[0]->url;
		//$variable2 = $response->next_page;
		//$variable3 = $response->previous_page;
		// if (empty($variable3)) {
		//   return "Es nulo o vacio";
		// }
		// $data = array(
		// 	'next_page' => $response->next_page, 
		// 	'previous_page' => $response->previous_page
		// );
    	//DB::connection('zendesk')->table('authtoken')->select
		$url = "https://sitwifi.zendesk.com/api/v2/search.json?query=created>2012-12-26&sort_by=created_at&sort_order=asc";

		$response = $this->curlZen($url);

		if (empty($response)) {
			return "no funciona cURL";
		}else{
			$count = $response->count;
			$next_page = $response->next_page;
			$regnum = count($response->results);
			DB::beginTransaction();
			while (!empty($next_page)) {
				for ($i=0; $i < $regnum; $i++) {
					if (empty($response->results[$i]->via->channel)) {
						$channel = "";
					}else{
						$channel = $response->results[$i]->via->channel;
					}

					
					$tagcount = count($response->results[$i]->tags);
					$tags = "";
					$collaboratorcount = count($response->results[$i]->collaborator_ids);
					$collaborator_ids = "";
					$customcount = count($response->results[$i]->custom_fields);
					$custom_fields = "";

					for ($j=0; $j < $tagcount; $j++) { 
						$tags = $tags . $response->results[$i]->tags[$j] . "&";
					}

					for ($k=0; $k < $collaboratorcount; $k++) { 
						$collaborator_ids = $collaborator_ids . $response->results[$i]->collaborator_ids[$k] . "&";
					}

					for ($l=0; $l < $customcount; $l++) { 
						$custom_fields = $custom_fields . $response->results[$i]->custom_fields[$l]->value . "&";
					}

					if (empty($response->results[$i]->via->source->from->address)) {
						$viafromaddress = "";
					}else{
						$viafromaddress = $response->results[$i]->via->source->from->address;
					}

					if (empty($response->results[$i]->via->source->from->name)) {
						$viafromname = "";
					}else{
						$viafromname = $response->results[$i]->via->source->from->name;
					}

					if (empty($response->results[$i]->via->source->to->name)) {
						$viatoname = "";
					}else{
						$viatoname = $response->results[$i]->via->source->to->name;
					}

					if (empty($response->results[$i]->via->source->to->address)) {
						$viatoaddress = "";
					}else{
						$viatoaddress = $response->results[$i]->via->source->to->address;
					}

					if (empty($response->results[$i]->external_id)) {
						$external_id = "";
					}else{
						$external_id = $response->results[$i]->external_id;
					}

					if (empty($response->results[$i]->type)) {
						$tipo = "";
					}else{
						$tipo = $response->results[$i]->type;
					}

					if (empty($response->results[$i]->status)) {
						$status = "";
					}else{
						$status = $response->results[$i]->status;
					}

					if (empty($response->results[$i]->priority)) {
						$priority = "";
					}else{
						$priority = $response->results[$i]->priority;
					}

					if (empty($response->results[$i]->recipient)) {
						$recipient = "";
					}else{
						$recipient =$response->results[$i]->recipient;
					}

					if (empty($response->results[$i]->organization_id)) {
						$organization_id = "";
					}else{
						$organization_id = $response->results[$i]->organization_id;
					}

					if (empty($response->results[$i]->forum_topic_id)) {
						$forum_topic_id = "";
					}else{
						$forum_topic_id = $response->results[$i]->forum_topic_id;
					}

					if (empty($response->results[$i]->problem_id)) {
						$problem_id = "";
					}else{
						$problem_id = $response->results[$i]->problem_id;
					}

					if (empty($response->results[$i]->due_at)) {
						$due_at = "";
					}else{
						$due_at = $response->results[$i]->due_at;
					}

					if (empty($response->results[$i]->satisfaction_rating->score)) {
						$score = "";
					}else{
						$score = $response->results[$i]->satisfaction_rating->score;
					}
									

					$tags = substr($tags, 0, -1);
					$collaborator_ids = substr($collaborator_ids, 0, -1);
					$custom_fields = substr($custom_fields, 0, -1);

					if ($channel == "email") {
						DB::connection('zendesk')->table('tickets')->insert([
							[
								'id_ticket' => $response->results[$i]->id,
								'url' => $response->results[$i]->url,
								'external_id' => $external_id,
								'type' => $tipo,
								'subject' => $response->results[$i]->subject,
								'raw_subject' => $response->results[$i]->raw_subject,
								'description' => $response->results[$i]->description,
								'status' => $status,
								'priority' => $priority,
								'recipient' => $recipient,
								'requester_id' => $response->results[$i]->requester_id,
								'submitter_id' => $response->results[$i]->submitter_id,
								'assignee_id' => $response->results[$i]->assignee_id,
								'organization_id' => $organization_id,
								'group_id' => $response->results[$i]->group_id,

								'collaboraor_ids' => $collaborator_ids,

								'forum_topic_id' => $forum_topic_id,
								'problem_id' => $problem_id,
								'has_incidents' => $response->results[$i]->has_incidents,
								'due_at' => $due_at,

								'tags' => $tags,

								'via_channel' => $channel,
								'via_from_address' => $viafromaddress,
								'via_from_name' => $viafromname,
								'via_to_name' => $viatoname,
								'via_to_address' => $viatoaddress,

								'custom_fields' => $custom_fields,

								'satisfaction_rating' => $score,
								'created_at' => $response->results[$i]->created_at,
								'updated_at' => $response->results[$i]->updated_at,
								//'agentes_id_user' => $response->results[$i]->assignee_id,
							]
						]);
						echo "EEEXITO";
					}else{
						DB::connection('zendesk')->table('tickets')->insert([
							[
								'id_ticket' => $response->results[$i]->id,
								'url' => $response->results[$i]->url,
								'external_id' => $external_id,
								'type' => $tipo,
								'subject' => $response->results[$i]->subject,
								'raw_subject' => $response->results[$i]->raw_subject,
								'description' => $response->results[$i]->description,
								'status' => $status,
								'priority' => $priority,
								'recipient' => $recipient,
								'requester_id' => $response->results[$i]->requester_id,
								'submitter_id' => $response->results[$i]->submitter_id,
								'assignee_id' => $response->results[$i]->assignee_id,
								'organization_id' => $organization_id,
								'group_id' => $response->results[$i]->group_id,

								'collaboraor_ids' => $collaborator_ids,

								'forum_topic_id' => $forum_topic_id,
								'problem_id' => $problem_id,
								'has_incidents' => $response->results[$i]->has_incidents,
								'due_at' => $due_at,

								'tags' => $tags,

								'via_channel' => $channel,

								'custom_fields' => $custom_fields,

								'satisfaction_rating' => $score,
								'created_at' => $response->results[$i]->created_at,
								'updated_at' => $response->results[$i]->updated_at,
								//'agentes_id_user' => $response->results[$i]->assignee_id,
							]
						]);
						echo "EXIIITOOO";
					}

					$response = $this->curlZen($next_page);
					$next_page = $response->next_page;
				}
				DB::commit();
			}
			return "EXIIITOO";
		}



    }

    public function curlZen($url)
    {
    	$ch = curl_init();
		//echo "Inicializa la funcion .. ";
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false );
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERPWD, "jesquinca@sitwifi.com/token:f4qs3fDR9b9J635IcP6Ce5cGXxKx32ewexk3qmvz");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");

		//curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		//echo ".. Termina la funcion ..";
		$output = curl_exec($ch);

		$curlerr = curl_error($ch);
		$curlerrno = curl_errno($ch);

		if ($curlerrno != 0) {
			// Retornar un num de error
        	return 0;
      	}
      	curl_close($ch);
      	$decoded = json_decode($output);

      	return $decoded;
    }
}
