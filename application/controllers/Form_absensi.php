<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Form_absensi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function kehadiran($ar_id)
    {
        $data['page_name'] = "Absensi Rapat";
        $ar_id_decode = $this->template->sonDecode($ar_id);
        $data['ar_id'] = $ar_id;
        $data['ar_id_decode'] = $ar_id_decode;
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id_decode]);
        $data['absensi_rapat'] = $absensi_rapat;

        // Tanggal hari.
        $tgl1 = strtotime(date("Y-m-d"));
        $tgl2 = strtotime($absensi_rapat['ar_tanggal']);
        $jarak = $tgl2 - $tgl1;
        $hari = $jarak / 60 / 60 / 24;
        // if ($hari <= 5) {
        //     if (($hari >= 0) || $hari >= -5) {
        //         $this->template->load('template/template-absensi', 'form_absensi/index_form', $data);
        //     } else {
        //         $this->template->load('template/template-absensi', 'form_absensi/index_unknwon', $data);
        //     }
        // } else {
        //     $this->template->load('template/template-absensi', 'form_absensi/index_unknwon', $data);
        // }

        $this->template->load('template/template-absensi', 'form_absensi/index_form', $data);
    }

    public function dropdown_perwakilan()
    {
        $posisi = $this->input->post('posisi');
        $array = array();
        if ($posisi == "") {
            $array[] = array(
                'id' => "-",
                'text' => "--- Pilih Jabatan ---"
            );
            echo json_encode($array);
        } else {
            if ($posisi == "Direksi") {
                $posisi = 1;
            }elseif ($posisi == "Komisaris") {
                $posisi = 3;
            } else {
                $posisi = 2;
            }

            $this->db->select('mpj_id,mpj_nama');
            $jabatan = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => $posisi, 'status' => 'ENABLE']);
            foreach ($jabatan as $key) {
                $array[] = array(
                    "id" => $key['mpj_id'],
                    "text" => $key['mpj_nama']
                );
            }
            echo json_encode($array);
        }
    }

    public function dropdown_jabatan_perwakilan()
    {
        $jabatan = $this->input->post('jabatan');
        $ar_id =  $this->template->sonDecode($this->input->post('ar_id'));
        $this->db->select('ar_tipe_rapat');
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);

        $array = array();
        if ($jabatan == "") {
            $array[] = array(
                'id' => "-",
                'text' => "--- Mewakili Sebagai ---"
            );
            echo json_encode($array);
        } else {

            if ($absensi_rapat['ar_tipe_rapat'] == 'komite_komisaris') {
                $this->db->select('mpj_id,mpj_nama');
                $jabatan = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => '3', 'mpj_id !=' => $jabatan, 'status' => 'ENABLE']);
            }else{
                $this->db->select('mpj_id,mpj_nama');
                $jabatan = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => '1', 'mpj_id !=' => $jabatan, 'status' => 'ENABLE']);
            }

            foreach ($jabatan as $key) {

                // Cek Jabatan apakah sudah pernah absensi apa belum
                $cek_absen = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_ar_id' => $ar_id, 'are_mpj_id' => $key['mpj_id']]);
                if ($cek_absen['are_id'] == NULL) {
                    $array[] = array(
                        "id" => $key['mpj_id'],
                        "text" => $key['mpj_nama']
                    );
                }
            }
            echo json_encode($array);
        }
    }

    public function cek_absensi_jabatan()
    {
        $posisi = $this->input->post('posisi');
        $jabatan = $this->input->post('jabatan');
        $ar_id = $this->template->sonDecode($this->input->post('ar_id'));
        $cek_absensi = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_ar_id' => $ar_id, 'are_tipe' => $posisi, 'are_mpj_id' => $jabatan]);
        if ($cek_absensi['are_id'] != NULL) {
            echo "sudah absen";
        } else {
            echo "belum absen";
        }
    }

    public function cek_absensi_divisi()
    {
        $posisi = $this->input->post('posisi');
        $divisi = $this->input->post('divisi');
        $ar_id = $this->template->sonDecode($this->input->post('ar_id'));

        $datanya = '"' . $divisi . '"';
        if ($posisi == "Pendamping") {
            $query = "SELECT ara_id FROM `absensi_rapat_agenda` WHERE ara_ar_id = $ar_id AND ara_id_divisi_pendamping LIKE '%$datanya%';";
        } else {
            $query = "SELECT ara_id FROM `absensi_rapat_agenda` WHERE ara_ar_id = $ar_id AND ara_id_divisi_materi LIKE '%$datanya%';";
        }
        $cekdivisi = $this->mymodel->selectWithQuery($query);
        if (count($cekdivisi) == 0) {
            echo "tidak ada";
        } else {
            echo "tersedia";
        }
    }

    public function cek_kuorum()
    {
        $ar_id = $this->template->sonDecode($this->input->post('ar_id'));
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);

        $this->db->select('COUNT(are_id) as jumlah_hadir');
        $this->db->where_in('are_status_kehadiran', ['Hadir', 'Hadir Diwakilkan']);
        $this->db->where('are_ar_id', $ar_id);
        $query_kehadiran = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_tipe' => 'Direksi']);
        $jumlah_hadir = $query_kehadiran['jumlah_hadir'];

        $jumlah_kuorum = $this->mymodel->selectWhere('m_posisi_jabatan', ['status' => 'ENABLE', 'mpj_mp_id' => 1]);

        if ($jumlah_kuorum == $jumlah_hadir) {
            echo "penuh";
        } else {
            echo "berlaku";
        }
    }

    public function store_absensi()
    {
        $post_data = $this->input->post();
        $ar_id = $this->template->sonDecode($post_data['ar_id']);
        $posisi = $post_data['dt']['posisi'];
        if (($posisi == "Pemateri") || ($posisi == "Pendamping") || ($posisi == "Non Komisaris")) {
            // Enroll Data untuk Divisi yang hadir
            $tipe = $posisi;
            $divisi = @$post_data['dt']['divisi'];
            $divisi_detail = $this->mymodel->selectDataone('m_divisi', ['md_id' => $divisi]);

            $enroll_absensi = array(
                'are_ar_id' => $ar_id,
                'are_tipe' => $tipe,
                'are_status_kehadiran' => 'Hadir',
                'are_md_id' => @$divisi,
                'are_md_nama' => @$divisi_detail['md_nama'],
                'are_nama_pejabat_divisi' => $post_data['dt']['nama_pejabat'],
                'created_at' => date("Y-m-d H:i:s")
            );

            // Enroll Absensi
            $this->mymodel->insertData('absensi_rapat_enroll', $enroll_absensi);
            $last_id = $this->db->insert_id();

            // Handle signature pad / tanda tangan
            $data_uri = $post_data['ttd'];
            $encoded_image = explode(",", $data_uri)[1];
            $decoded_image = base64_decode($encoded_image);
            $ttd_name = "ttd_" . $ar_id . "_" . $last_id . ".png";
            file_put_contents("webfile/ttd_absensi_rapat/" . $ttd_name, $decoded_image);

            // Update field ttd ke data absensi.
            $this->mymodel->updateData('absensi_rapat_enroll', ['are_ttd' => $ttd_name], ['are_id' => $last_id]);
        } else if ($posisi == "SEVP") {
            $tipe = $posisi;
            $jabatan = $post_data['dt']['jabatan'];
            $jabatan_detail = $this->mymodel->selectDataone('m_posisi_jabatan', ['mpj_id' => $jabatan, 'status' => 'ENABLE']);
            $enroll_absensi = array(
                'are_ar_id' => $ar_id,
                'are_tipe' => $tipe,
                'are_status_kehadiran' => "Hadir",
                'are_mpj_id' => $jabatan,
                'are_mpj_nama' => $jabatan_detail['mpj_nama'],
                'created_at' => date("Y-m-d H:i:s")
            );

            // Enroll Absensi
            $this->mymodel->insertData('absensi_rapat_enroll', $enroll_absensi);
            $last_id = $this->db->insert_id();

            if(isset($jabatan_detail['mpj_ttd'])) {
                //ambil extension
                $file_ext = pathinfo($jabatan_detail['mpj_ttd'], PATHINFO_EXTENSION);

                $sumber = './webfile/ttd_sevp_direksi/'.$jabatan_detail['mpj_ttd']; 
                $tujuan = './webfile/ttd_absensi_rapat/ttd_'. $ar_id . "_" . $last_id . "." . $file_ext; 

                //copy file
                copy($sumber, $tujuan);
                
                $ttd_name = "ttd_" . $ar_id . "_" . $last_id . "." . $file_ext;
            } else {
                $ttd_name = null;
            }

            // Update field ttd ke data absensi.
            $this->mymodel->updateData('absensi_rapat_enroll', ['are_ttd' => $ttd_name], ['are_id' => $last_id]);
        }elseif($posisi == "Komisaris"){

            $jabatan_detail = $this->mymodel->selectDataone('m_posisi_jabatan', ['mpj_id' => $jabatan, 'status' => 'ENABLE']);

            //Enrool data untuk komisaris
            $tipe = $posisi;
            $jabatan = $post_data['dt']['jabatan'];
            $status = $post_data['dt']['status'];
            $jabatan_diwakilkan = $post_data['dt']['jabatan_diwakilkan'];

            $enroll_absensi = array(
                'are_ar_id' => $ar_id,
                'are_tipe' => $tipe,
                'are_status_kehadiran' => "Hadir",
                'are_mpj_id' => $jabatan,
                'are_mpj_nama' => $jabatan_detail['mpj_nama'],
                'created_at' => date("Y-m-d H:i:s")
            );

            // Enroll Absensi
            $this->mymodel->insertData('absensi_rapat_enroll', $enroll_absensi);
            $last_id = $this->db->insert_id();

            // Handle signature pad / tanda tangan
            $data_uri = $post_data['ttd'];
            $encoded_image = explode(",", $data_uri)[1];
            $decoded_image = base64_decode($encoded_image);
            $ttd_name = "ttd_" . $ar_id . "_" . $last_id . ".png";
            file_put_contents("webfile/ttd_absensi_rapat/" . $ttd_name, $decoded_image);

            // Update field ttd ke data absensi.
            $this->mymodel->updateData('absensi_rapat_enroll', ['are_ttd' => $ttd_name], ['are_id' => $last_id]);

            $this->db->select('are_ttd');
            $absensi_masuk = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_id'=>$last_id]);

            if ($jabatan_diwakilkan != "-") {
                $jabatan_diwakilkan_detail = $this->mymodel->selectDataone('m_posisi_jabatan', ['mpj_id' => $jabatan_diwakilkan, 'status' => 'ENABLE']);
                // Enroll Pejabat Yang Diwakilkan 
                $enroll_absensi_diwakilkan = array(
                    'are_ar_id' => $ar_id,
                    'are_tipe' => $tipe,
                    'are_status_kehadiran' => "Hadir Diwakilkan",
                    'are_mpj_id' => $jabatan_diwakilkan_detail['mpj_id'],
                    'are_mpj_nama' => $jabatan_diwakilkan_detail['mpj_nama'],
                    'are_mpj_id_perwakilan' => $jabatan_detail['mpj_id'],
                    'are_mpj_nama_perwakilan' => $jabatan_detail['mpj_nama'],
                    'created_at' => date('Y-m-d H:i:s')
                );
                // Enroll Absensi
                $this->mymodel->insertData('absensi_rapat_enroll', $enroll_absensi_diwakilkan);
                $last_id_diwakilkan = $this->db->insert_id();

                if(@$absensi_masuk['are_ttd'] != '') {
                    //ambil extension
                    $file_ext = pathinfo($absensi_masuk['are_ttd'], PATHINFO_EXTENSION);
    
                    $sumber = './webfile/ttd_absensi_rapat/'.$absensi_masuk['are_ttd']; 
                    $tujuan = './webfile/ttd_absensi_rapat/ttd_'. $ar_id . "_" . $last_id . "." . $file_ext; 
    
                    //copy file
                    copy($sumber, $tujuan);
                    
                    $ttd_name = "ttd_" . $ar_id . "_" . $last_id . "." . $file_ext;
                } else {
                    $ttd_name = null;
                }

                // Update field ttd ke data absensi.
                $this->mymodel->updateData('absensi_rapat_enroll', ['are_ttd' => $ttd_name], ['are_id' => $last_id_diwakilkan]);
            }


        }else {
            // Enroll Data untuk Direksi yang hadir
            $tipe = $posisi;
            $jabatan = $post_data['dt']['jabatan'];
            $status = $post_data['dt']['status'];
            $jabatan_diwakilkan = $post_data['dt']['jabatan_diwakilkan'];

            // Cek Status
            $trap_perwakilan = 0;
            foreach ($status as $sts) {
                if ($sts == "Hadir Mewakilkan") {
                    $trap_perwakilan += 1;
                } else {
                    $trap_perwakilan += 0;
                }
            }

            if ($trap_perwakilan == 1) {
                $jabatan_detail = $this->mymodel->selectDataone('m_posisi_jabatan', ['mpj_id' => $jabatan, 'status' => 'ENABLE']);

                // Enroll Pejabat Yang Hadir
                $enroll_absensi = array(
                    'are_ar_id' => $ar_id,
                    'are_tipe' => $tipe,
                    'are_status_kehadiran' => "Hadir",
                    'are_mpj_id' => $jabatan_detail['mpj_id'],
                    'are_mpj_nama' => $jabatan_detail['mpj_nama'],
                    'created_at' => date('Y-m-d H:i:s')
                );
                // Enroll Absensi
                $this->mymodel->insertData('absensi_rapat_enroll', $enroll_absensi);
                $last_id = $this->db->insert_id();

                if(isset($jabatan_detail['mpj_ttd'])) {
                    //ambil extension
                    $file_ext = pathinfo($jabatan_detail['mpj_ttd'], PATHINFO_EXTENSION);
    
                    $sumber = './webfile/ttd_sevp_direksi/'.$jabatan_detail['mpj_ttd']; 
                    $tujuan = './webfile/ttd_absensi_rapat/ttd_'. $ar_id . "_" . $last_id . "." . $file_ext; 
    
                    //copy file
                    copy($sumber, $tujuan);
                    
                    $ttd_name = "ttd_" . $ar_id . "_" . $last_id . "." . $file_ext;
                } else {
                    $ttd_name = null;
                }

                // Update field ttd ke data absensi.
                $this->mymodel->updateData('absensi_rapat_enroll', ['are_ttd' => $ttd_name], ['are_id' => $last_id]);
                if ($jabatan_diwakilkan != "-") {
                    $jabatan_diwakilkan_detail = $this->mymodel->selectDataone('m_posisi_jabatan', ['mpj_id' => $jabatan_diwakilkan, 'status' => 'ENABLE']);
                    // Enroll Pejabat Yang Diwakilkan 
                    $enroll_absensi_diwakilkan = array(
                        'are_ar_id' => $ar_id,
                        'are_tipe' => $tipe,
                        'are_status_kehadiran' => "Hadir Diwakilkan",
                        'are_mpj_id' => $jabatan_diwakilkan_detail['mpj_id'],
                        'are_mpj_nama' => $jabatan_diwakilkan_detail['mpj_nama'],
                        'are_mpj_id_perwakilan' => $jabatan_detail['mpj_id'],
                        'are_mpj_nama_perwakilan' => $jabatan_detail['mpj_nama'],
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    // Enroll Absensi
                    $this->mymodel->insertData('absensi_rapat_enroll', $enroll_absensi_diwakilkan);
                    $last_id_diwakilkan = $this->db->insert_id();

                    if(isset($jabatan_detail['mpj_ttd'])) {
                        //ambil extension
                        $file_ext = pathinfo($jabatan_detail['mpj_ttd'], PATHINFO_EXTENSION);
        
                        $sumber = './webfile/ttd_sevp_direksi/'.$jabatan_detail['mpj_ttd']; 
                        $tujuan = './webfile/ttd_absensi_rapat/ttd_'. $ar_id . "_" . $last_id . "." . $file_ext; 
        
                        //copy file
                        copy($sumber, $tujuan);
                        
                        $ttd_name = "ttd_" . $ar_id . "_" . $last_id . "." . $file_ext;
                    } else {
                        $ttd_name = null;
                    }

                    // Update field ttd ke data absensi.
                    $this->mymodel->updateData('absensi_rapat_enroll', ['are_ttd' => $ttd_name], ['are_id' => $last_id_diwakilkan]);
                }
            } else {
                $jabatan_detail = $this->mymodel->selectDataone('m_posisi_jabatan', ['mpj_id' => $jabatan, 'status' => 'ENABLE']);
                $enroll_absensi = array(
                    'are_ar_id' => $ar_id,
                    'are_tipe' => $tipe,
                    'are_status_kehadiran' => "Hadir",
                    'are_mpj_id' => $jabatan,
                    'are_mpj_nama' => $jabatan_detail['mpj_nama'],
                    'created_at' => date("Y-m-d H:i:s")
                );

                // Enroll Absensi
                $this->mymodel->insertData('absensi_rapat_enroll', $enroll_absensi);
                $last_id = $this->db->insert_id();

                if(isset($jabatan_detail['mpj_ttd'])) {
                    //ambil extension
                    $file_ext = pathinfo($jabatan_detail['mpj_ttd'], PATHINFO_EXTENSION);
    
                    $sumber = './webfile/ttd_sevp_direksi/'.$jabatan_detail['mpj_ttd']; 
                    $tujuan = './webfile/ttd_absensi_rapat/ttd_'. $ar_id . "_" . $last_id . "." . $file_ext; 
    
                    //copy file
                    copy($sumber, $tujuan);
                    
                    $ttd_name = "ttd_" . $ar_id . "_" . $last_id . "." . $file_ext;
                } else {
                    $ttd_name = null;
                }

                // Update field ttd ke data absensi.
                $this->mymodel->updateData('absensi_rapat_enroll', ['are_ttd' => $ttd_name], ['are_id' => $last_id]);
            }
        }

        echo "success";
    }

    public function kehadiran_rapat($ar_id)
    {
        $data['page_name'] = "Detail Absensi Rapat";
        $ar_id_decode = $this->template->sonDecode($ar_id);
        $data['ar_id'] = $ar_id;
        $data['ar_id_decode'] = $ar_id_decode;
        $data['absensi_rapat'] = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id_decode]);
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id_decode]);
        $data['absensi_rapat_agenda'] = $this->mymodel->selectWhere('absensi_rapat_agenda', ['ara_ar_id' => $ar_id_decode]);
        // Tanggal hari.
        $tgl1 = strtotime(date("Y-m-d"));
        $tgl2 = strtotime($absensi_rapat['ar_tanggal']);
        $jarak = $tgl2 - $tgl1;
        $hari = $jarak / 60 / 60 / 24;
        if ($hari <= 4) {
            if (($hari >= 0) || $hari >= -5) {
                $this->template->load('template/template-absensi', 'form_absensi/index_detail_rapat', $data);
            } else {
                $this->template->load('template/template-absensi', 'form_absensi/index_unknwon', $data);
            }
        } else {
            $this->template->load('template/template-absensi', 'form_absensi/index_unknwon', $data);
        }
    }
}
