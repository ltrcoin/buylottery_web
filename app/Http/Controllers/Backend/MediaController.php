<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
	public function image(Request $request)
	{
		try {
			$validator = Validator::make($request->all(), [
				'img' => 'required|mimes:jpeg,jpg,png'
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->get('img');
				$errors = implode(' ', $errors);
				return response()->json([
					'status' => 'error',
					'message' => $errors
				]);
			}

			$path = $request->img->store('public/tmp');
			$imageInfo = getimagesize(storage_path('app/' . $path));
			$response = [
				'status' => 'success',
				'url' => str_replace('public/', '/storage/', $path),
				'width' => $imageInfo[0],
				'height' => $imageInfo[1],
			];
		} catch (\Exception $e) {
			$response = [
				'status' => 'error',
				'message' => $e->getMessage()
			];
		}

		return response()->json($response);
	}

	public function imageCrop(Request $request)
	{
		$data = $request->all();

		$imgUrl = storage_path('app/' . str_replace('/storage/', 'public/', $data['imgUrl']));
		// original sizes
		$imgInitW = $data['imgInitW'];
		$imgInitH = $data['imgInitH'];
		// resized sizes
		$imgW = $data['imgW'];
		$imgH = $data['imgH'];
		// offsets
		$imgY1 = $data['imgY1'];
		$imgX1 = $data['imgX1'];
		// crop box
		$cropW = $data['cropW'];
		$cropH = $data['cropH'];
		// rotation angle
		$angle = $data['rotation'];

		$jpeg_quality = 85;
		$png_quality = 6;

		$output_filename = storage_path() . "/app/public/tmp/croppedImg_" . rand();

		$what = getimagesize($imgUrl);

		switch (strtolower($what['mime'])) {
			case 'image/png':
				$img_r = imagecreatefrompng($imgUrl);
				$source_image = imagecreatefrompng($imgUrl);
				$type = '.png';
				break;
			case 'image/jpeg':
				$img_r = imagecreatefromjpeg($imgUrl);
				$source_image = imagecreatefromjpeg($imgUrl);
				error_log("jpg");
				$type = '.jpeg';
				break;
			case 'image/gif':
				$img_r = imagecreatefromgif($imgUrl);
				$source_image = imagecreatefromgif($imgUrl);
				$type = '.gif';
				break;
			default:
				die('image type not supported');
		}


		//Check write Access to Directory

		if (!is_writable(dirname($output_filename))) {
			$response = [
				"status" => 'error',
				"message" => 'Can`t write cropped File',
				'output_filename' => $output_filename
			];
		} else {
			// resize the original image to size of editor
			$resizedImage = imagecreatetruecolor($imgW, $imgH);
			imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
			// rotate the rezized image
			$rotated_image = imagerotate($resizedImage, -$angle, 0);
			// find new width & height of rotated image
			$rotated_width = imagesx($rotated_image);
			$rotated_height = imagesy($rotated_image);
			// diff between rotated & original sizes
			$dx = $rotated_width - $imgW;
			$dy = $rotated_height - $imgH;
			// crop rotated image to fit into original rezized rectangle
			$cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
			imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
			imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW,
				$imgH);
			// crop image into selected area
			$final_image = imagecreatetruecolor($cropW, $cropH);
			imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
			imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW,
				$cropH);
			// finally output png image
			if ($type === '.png') {
				imagepng($final_image, $output_filename . $type, $png_quality);
			} else {
				imagejpeg($final_image, $output_filename . $type, $jpeg_quality);
			}

			unlink($imgUrl);

			$response = [
				"status" => 'success',
				"url" => str_replace(storage_path('app/public'), '/storage', $output_filename . $type),
			];
		}

		return response()->json($response);
	}
}
