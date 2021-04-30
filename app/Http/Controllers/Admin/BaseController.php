<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Image, File AS FileInput, DB, Auth;
use Spiderworks\Webadmin\Models\Media;

class BaseController extends Controller {

    protected $route, $views;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->route = $this->views = 'admin';
    }

    protected function uploadFile($fileInput = 'image', $filePath = 'uploads/', $varient=array()) {

        $destinationPath = public_path($filePath);
        $returnFilename = null;
        $result = array('success' => false, 'error' => '', 'filepath' => '');
        $file = is_object($fileInput) ? $fileInput : Request::file($fileInput);



        if ( (is_object($fileInput) || Request::hasFile($fileInput)) && $file->isValid()) {
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $fileType = $file->getMimeType();

            $fileDimensions = null;
            if(substr($file->getMimeType(), 0, 5) == 'image') {
                $type = "Image";
                $imagedetails = getimagesize($file);
                $width = $imagedetails[0];
                $height = $imagedetails[1];
                $fileDimensions = $width." X ".$height;
                $thumb_image = '';
            }
            else if(substr($file->getMimeType(), 0, 5) == 'video') {
                $type = "Video";
                $thumb_image = 'webadmin/img/docs/video.jpg';
            }
            else if(substr($file->getMimeType(), 0, 5) == 'audio') {
                $type = "Audio";
                $thumb_image = 'webadmin/img/docs/audio.png';
            }
            else if($file->getMimeType() == 'application/msword') {
                $type = "DOC";
                $thumb_image = 'webadmin/img/docs/doc.png';
            }
            else if($file->getMimeType() == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                $type = "DOCX";
                $thumb_image = 'webadmin/img/docs/docx.png';
            }
            else if($file->getMimeType() == 'application/vnd.ms-excel') {
                $type = "XLS";
                $thumb_image = 'webadmin/img/docs/xls.png';
            }
            else if($file->getMimeType() == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                $type = "XLSX";
                $thumb_image = 'webadmin/img/docs/xlsx.png';
            }
            else if($file->getMimeType() == 'application/vnd.ms-powerpoint') {
                $type = "PPT";
                $thumb_image = 'webadmin/img/docs/ppt.png';
            }
            else if($file->getMimeType() == 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
                $type = "PPTX";
                $thumb_image = 'webadmin/img/docs/pptx.png';
            }
            else if($file->getMimeType() == 'application/pdf') {
                $type = "PDF";
                $thumb_image = 'webadmin/img/docs/pdf.jpg';
            }
            else {
                $type = "File";
                $thumb_image = 'webadmin/img/docs/file.png';
            }


            $file_parts = pathinfo($fileName);
            $file_ext = $file_parts['extension'];
            $file_name = $file_parts['filename'];
            $i = 0;
            $extra = uniqid();
            while (file_exists($destinationPath . $file_name . $extra . '.' . $file_ext)) {
                $i++;
                $extra = '_' . $i;
            }
            $fileName = $file_name . $extra . '.' . $file_ext;

            if(!FileInput::isDirectory($destinationPath)) {
                // path does not exist
                FileInput::makeDirectory($destinationPath, 0755, true);
            }
            $success = false;
            if($type == 'Image')
            {
                $file_obj = Image::make($file);
                if($file_obj->save($destinationPath.$fileName))
                {
                    $success = true;

                    //save thumbnail
                    $thumbDestPath = 'public/uploads/thumbnails';
                    if(!FileInput::isDirectory($thumbDestPath)) {
                        FileInput::makeDirectory($thumbDestPath, 0755, true);
                    }
                    $this->create_image(200, 200, $thumbDestPath, $fileName, $file);
                    $thumb_image = 'uploads/thumbnails/'.$fileName;
                    if($varient)
                    {
                        $image_varients = DB::table('media_types')->select('media_settings.width', 'media_settings.height', 'media_types.path')->join('media_settings', 'media_settings.media_type_id', '=', 'media_types.id')->whereNull('media_settings.deleted_at')->whereIn('media_types.type', $varient)->get();
                        if($image_varients)
                        {
                            foreach ($image_varients as $key => $img_varient) {
                                $folder = $img_varient->width.'X'.$img_varient->height;
                                $varient_desctination_path = $img_varient->path.'/'.$folder;
                                if(!FileInput::isDirectory($varient_desctination_path)) {
                                    FileInput::makeDirectory($varient_desctination_path, 0755, true);
                                }
                                $this->create_image($img_varient->width, $img_varient->height, $varient_desctination_path, $fileName, $file);

                            }
                        }
                    }
                }

            }
            elseif( $file->move($destinationPath, $fileName) ) {
                $success = true;
            }
            if($success)
            {
                $result['filename'] = $fileName;
                $result['filepath'] = $filePath . $fileName;
                $result['filesize'] = $fileSize;
                $result['filedimensions'] = $fileDimensions;
                $result['mediatype'] = $type;
                $result['mediathumb'] = $thumb_image;
                $result['filetype'] = $fileType;
                $result['success'] = true;
            }
            else
                $result['error'] = 'Something wrong happend, please try again.';
        } else {
            $result['error'] = 'No file selected or Invalid file.';
        }
        return $result;
    }

    public function create_image($width, $height, $destination, $filename, $file)
    {
        // create new image with transparent background color
        $background = Image::canvas($width, $height);

        // read image file and resize it to 200x200
        // but keep aspect-ratio and do not size up,
        // so smaller sizes don't stretch
        $image = Image::make($file)->resize($width, $height, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });

        // insert resized image centered into background
        $background->insert($image, 'center');

        // save or do whatever you like
        $background->save($destination.'/'.$filename, 100);
        return true;
    }

    public static function slug($slug){
        return strtolower(preg_replace( '/[-+()^ $%&.*~]+/', '-', $slug));
    }

    public function saveMedia($upload)
    {
        $media = new Media;
        $media->file_name = $upload['filename'];
        $media->file_path = $upload['filepath'];
        $media->thumb_file_path = $upload['mediathumb'];
        $media->file_type = $upload['filetype'];
        $media->file_size = $upload['filesize'];
        $media->dimensions = $upload['filedimensions'];
        $media->media_type = $upload['mediatype'];
        if(isset($upload['related_type']) && $upload['related_type']!='' && isset($upload['related_id']) && $upload['related_id']!='')
        {
            $media->related_type = $upload['related_type'];
            $media->related_id = $upload['related_id'];
        }
        $media->created_by = $media->updated_by = Auth::user()->id;
        $media->save();

        $data = array(
            'name' => $media->file_name,
            'size' => $media->file_size,
            'id' => $media->id,
            'original_file' => \URL::to('').'/public/'.$media->file_path,
            'type' => $media->file_type,
            'url' => $media->thumb_file_path,
        );
        return $data;
    }

}