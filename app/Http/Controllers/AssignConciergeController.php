<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\RedirectResponse;

use DB;

use Auth;

use SNMP;

class AssignConciergeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //$selectDataUser = DB::table('ListarUserReportes')->orderBy('id', 'asc')->get();
      $selectDataUser= DB::table('listarusuariosreportes')->select('IDUsuario','Encargado')->orderBy('IDUsuario', 'asc')->get();
      return view('assign.assign', compact('selectDataUser'));
      //return view('assign.assign');
    }
    public function recargar(Request $request){
      $id= $request->sector;
      $sql= DB::table('alonso')->select('hotelID','Nombre_hotel', 'userreporteID', 'itconciergeID')->where('hotelID', '=', $id)->get();
      return json_encode($sql);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show (Request $request)
     {
       /*
          $resultado = DB::table('HotelUserReport')->select('CorreosZD')
          */
         $resultado= DB::table('alonso')->select(
           'Nombre_hotel',
           'hotelID',
           'userreporteID',
           'Encargado'
          )->orderBy('hotelID', 'asc')->get();
         return json_encode($resultado);
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $value='1';
      $edita_idhotel= $request->hotel;
      $edita_iduserconci= $request->concierge;

      $emailuser = $this->getCorreo($edita_iduserconci);
      $edita_idconcierge = $this->getIdCon($emailuser);

      $sql = DB::table('hotels')->where('id', '=', $edita_idhotel)
      ->update(['user_reportes_id' => $edita_iduserconci, 'itconcierges_id' => $edita_idconcierge]);

      return $value;
    }

    public function getCorreo($value)
    {
      $resultado= DB::table('listarusuariosreportes')->select('email')->where('IDUsuario', '=', $value)->value('IDUsuario');

      return $resultado;
    }

    public function getIdCon($value)
    {
      $resultado= DB::table('itconcierges')->select('id')->where('email', '=', $value)->value('id');

      return $resultado;
    }

    public function rutaestadoserver()
    {
      $host = '200.78.168.233'; //ORP
      $host1 = '177.237.78.210:1161'; // OceanDream
      $host2 = '177.237.60.22:1611'; //Kore

      $host3 = '177.237.78.98:1161'; //Ibero-Paraiso ZD2
      $host4 = '177.237.78.100:1161'; //Ibero-Paraiso ZD3- MAL
      $host5 = '189.206.2.209:1161'; //Ibero-Cancun
      $host6 = '200.56.193.10:1161'; //Ibero playamita zd1 no hay info
      $host7 = '200.56.193.10:1162'; //Ibero playamita pendiente

      $host8 = '187.157.233.30:1161'; //Ibero cozumel

      $host9 = '177.237.79.186:1161'; //Ibero playacar si responde

      $host10= '187.217.115.165:1161';

      $host11= "187.157.165.6:1161"; //Azul beach bien
      $host12= "187.141.65.236:1161"; //sensatori
      $host13= "187.157.183.71:1161"; //azul five
      $host14= "187.217.120.133:1161";
      $host15 = "187.157.182.98:1161";
      $host16 = "187.157.182.98:2161";
      $host17 = "177.237.78.38:1611"; // Parnassus Great

      $host15="187.157.182.98:1161";
      $host16="187.157.182.98:2161";

      $boolean = 0;
      //187.157.151.52
      //201.161.132.22
      //187.252.50.79

      $session = new SNMP(SNMP::VERSION_2C, $host3, "public");
      try {
        $res = $session->walk("1.3.6.1.4.1.25053.1.2.2.1.1.2.1.1.4");
        var_dump($res);
      } catch (\Exception $e) {
        $boolean = $session->getErrno() == SNMP::ERRNO_TIMEOUT;
        var_dump($boolean);
      }
      echo $boolean;
      $session->close();
    }

    public function curlZen()
    {
      //define("ZDURL", "https://sitwifi.zendesk.com/api/v2/tickets.json");
      //$url = "https://sitwifi.zendesk.com/api/v2/search.json?query=type:user+email:jesquinca@sitwifi.com";
      //$url = "https://sitwifi.zendesk.com/api/v2/search.json?query=created>2016-12-31+type:ticket";
      $url = "https://sitwifi.zendesk.com/api/v2/search.json?query=created>2016-12-26&type:ticket&sort_by=created_at&sort_order=asc";
      //$url = "https://sitwifi.zendesk.com/api/v2/search.json?query=created>2016-12-31&created<2017-08-01&type:ticket&sort_by=created_at&sort_order=asc";
      $url2 = "https://sitwifi.zendesk.com/api/v2/search.json?page=31&query=created>2012-12-26&sort_by=created_at&sort_order=asc";

      $url3 = "https://sitwifi.zendesk.com/api/v2/search.json?query=created>2012-12-26&created<2017-09-01&type:ticket&sort_by=created_at&sort_order=asc";

      $url4 = "https://sitwifi.zendesk.com/api/v2/search.json?page=100&query=created%3E2012-12-26&sort_by=created_at&sort_order=asc";

      $urlnext = "https://sitwifi.zendesk.com/api/v2/search.json?page=101&query=created%3E2012-12-26&sort_by=created_at&sort_order=asc";

      $urlticket = "https://sitwifi.zendesk.com/api/v2/tickets/599.json";
      $urltickets = "https://sitwifi.zendesk.com/api/v2/tickets.json";
      $urlmetrics = "https://sitwifi.zendesk.com/api/v2/ticket_metrics.json";
      //$json = json_encode(array('ticket' => array('subject' => $arr['z_subject'], 'comment' => array( "value"=> $arr['z_description']), 'requester' => array('name' => $arr['z_name'], 'email' => $arr['z_requester']))));

      // created>2014-08-01 created<2014-08-05

      //$json2 = json_encode(array('' => ''));

      $ch = curl_init();
      //echo "Inicializa la funcion .. ";
      curl_setopt($ch, CURLOPT_TIMEOUT, 50);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false );
      curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
      curl_setopt($ch, CURLOPT_URL, $urlmetrics);
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
          return "Error en el curl";
      }else{

      }
      //echo '   Curl error number:  ' . curl_errno($ch) . '|| Curl error message: ' . curl_error($ch);
      curl_close($ch);
      $decoded = json_decode($output);
      // $numero = $decoded->results[0]->via->source->from->address;
      // $source = $decoded->results[0]->via;
      //$variable = $decoded->results[0]->url;
      //$variable2 = $decoded->next_page;
      //$variable3 = $decoded->previous_page;
      // if (empty($variable3)) {
      //   return "Es nulo o vacio";

      // $tags = $decoded->results[0]->tags[0];
      // $tagcount = count($decoded->results[0]->tags);

      // $satif = $decoded->results[0]->satisfaction_rating->score;

      // $custom = $decoded->results[0]->custom_fields[3]->value;
      // }

      // $colab = count($decoded->results[0]->collaborator_ids);
      // $collaborator_ids = "";

      //echo $decoded->results[0]->collaborator_ids[0];

      // for ($k=0; $k < $colab; $k++) {
      //   $collaborator_ids = $collaborator_ids . $decoded->results[0]->collaborator_ids[$k] . "&";
      // }
      // $collaborator_ids = substr($collaborator_ids, 0, -1);
      // $incident = $decoded->results[0]->has_incidents;
      //var_dump($decoded->results[0]->external_id);

      // $customcount = count($decoded->results[0]->custom_fields);
      // $custom1 = $decoded->results[0]->custom_fields[0]->value;

      $variable2 = $decoded->ticket_metrics[1]->reply_time_in_minutes;
      $variable3 = $decoded->ticket_metrics[1]->reply_time_in_minutes->business;
      $result = DB::connection('zendesk')->table('tickets')->pluck('id_ticket');
      dd($result);
      //return $output;

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
