<h1><?php _e('1. Define Object',$this->plugin_text_domain); ?></h1>

<?php
if($object_id == '')
	$object = array('id'=>'','title'=>'%TITLE%');
else{
	$object = $this->options['opengraph_objects'][$object_id];
}
if($copy == 'true')
	unset($object['id']);
if(!isset($object['object_title']))
	$object['object_title'] = '';
	
$ogp = $this->opengraph_array_to_object($object);
$form = new AWD_facebook_form('form_create_opengraph_object', 'POST', '', $this->plugin_option_pref);

echo $form->start();
	?>
	<div class="row">
		<?php
		//id of object
		echo $form->addInputHidden('awd_ogp[id]', $object['id']);
		//title of object
		echo $form->addInputText(__('Title of object (only for reference)',$this->plugin_text_domain),  'awd_ogp[object_title]', $object['object_title'], 'span4', array('class'=>'span4'));
		//Locale
		$locales = $ogp->supported_locales();
		$_locales = array();
		foreach($locales as $locale => $label){ $_locales[] = array('value'=>$locale, 'label'=> $label ); }
		echo $form->addSelect(__('Locale',$this->plugin_text_domain), 'awd_ogp[locale]', $_locales, $ogp->getLocale(), 'span4', array('class'=>'span2'));					
		?>
	</div>
	<div class="row">
		<?php
		//Determiners
		$_determiners = array(
			array('value'=> 'auto', 'label'=> __('Auto',$this->plugin_text_domain)),
			array('value'=> 'a', 'label'=> __('A',$this->plugin_text_domain)),
			array('value'=> 'an', 'label'=> __('An',$this->plugin_text_domain)),
			array('value'=> 'the', 'label'=> __('The',$this->plugin_text_domain))
		);
		echo $form->addSelect(__('The determiner',$this->plugin_text_domain), 'awd_ogp[determiner]', $_determiners, $ogp->getDeterminer(), 'span2', array('class'=>'span2'));					

		//title of the page
		echo $form->addInputText('Title',  'awd_ogp[title]', $ogp->getTitle(), 'span4', array('class'=>'span4'));
		//type
		$types = $ogp->supported_types(true);
		foreach($types as $type){ $options[] = array('value'=>$type, 'label'=> ucfirst($type)); }
		echo $form->addSelect(__('Type',$this->plugin_text_domain).' '.$this->get_the_help('type'), 'awd_ogp[type]', $options, $ogp->gettype(), 'span2', array('class'=>'span2'));
		?>
	</div>
	<div class="row">
		<?php
		//Description
		echo $form->addInputText('Description',  'awd_ogp[description]', $ogp->getDescription(), 'span6', array('class'=>'span6'));
		?>
	</div>
	<div class="row">
		<?php
		//Site name
		echo $form->addInputText('Site Name', 'awd_ogp[site_name]', $ogp->getSiteName(), 'span4', array('class'=>'span4'));
		//Url
		echo $form->addInputText('Url',  'awd_ogp[url]', $ogp->getUrl(), 'span4', array('class'=>'span4'));
		?>
	</div>
	<h1><?php _e('2. Add Media to Object',$this->plugin_text_domain); ?></h1>
	<h2><?php _e('Images',$this->plugin_text_domain); ?> <button class="btn btn-mini awd_add_media_field" data-label="<?php _e('Image url',$this->plugin_text_domain); ?>" data-label2="<?php _e('Upload an Image',$this->plugin_text_domain); ?>" data-type="image" data-name="awd_ogp[images][]"><i class="icon-picture"></i> Add an image</button></h2>
	<div class="row">
		<div class="awd_ogp_fields_image">
			<?php
			if(!isset($object['images']))
				$object['images'] = array();
			$images = $object['images'];
			if(count($images))
			{
				echo $form->addMediaButton('Image url', 'awd_ogp[images][]', $images[0],'span8', array('class'=>'span6'), array('data-title'=>__('Upload an Image',$this->plugin_text_domain), 'data-type'=> 'image'), false);
				unset($images[0]);
				foreach($images as $image)
				{
					echo $form->addMediaButton('Image url', 'awd_ogp[images][]', $image,'span8', array('class'=>'span6'), array('data-title'=>__('Upload an Image',$this->plugin_text_domain), 'data-type'=> 'image'), true);
				}
			}else{
				echo $form->addMediaButton('Image url', 'awd_ogp[images][]', '','span8', array('class'=>'span6'), array('data-title'=>__('Upload an Image',$this->plugin_text_domain), 'data-type'=> 'image'), false);
			}
			?>
		</div>
	</div>
	<h2><?php _e('Videos',$this->plugin_text_domain); ?> <button class="btn btn-mini awd_add_media_field" data-label="<?php _e('Video url',$this->plugin_text_domain); ?>" data-label2="<?php _e('Upload an Image',$this->plugin_text_domain); ?>" data-type="video" data-name="awd_ogp[videos][]"><i class="icon-film"></i> Add a video</button></h2>
	<div class="row">
		<div class="awd_ogp_fields_video">
			<?php echo $form->addMediaButton('Video url', 'awd_ogp[videos][]', '','span8', array('class'=>'span6'), array('data-title'=>__('Upload a Video',$this->plugin_text_domain), 'data-type'=> 'video'), false); ?>
		</div>
	</div>
	<h2><?php _e('Audios',$this->plugin_text_domain); ?> <button class="btn btn-mini awd_add_media_field" data-label="<?php _e('Audio url',$this->plugin_text_domain); ?>" data-label2="<?php _e('Upload an Image',$this->plugin_text_domain); ?>" data-type="audio" data-name="awd_ogp[audios][]"><i class="icon-music"></i> Add a song</button></h2>
	<div class="row">
		<div class="awd_ogp_fields_audio">
			<?php echo $form->addMediaButton('Audio url', 'awd_ogp[audios][]', '','span8', array('class'=>'span6'), array('data-title'=>__('Upload a Song',$this->plugin_text_domain), 'data-type'=> 'audio'), false); ?>
		</div>
	</div>
	
	<div class="form-actions">
		<div class="btn-group pull-right">
			<button class="btn btn-primary awd_submit_ogp"><i class="icon-ok icon-white"></i> <?php _e('Save this object',$this->plugin_text_domain); ?></button>
			<button class="btn btn-danger pull-right hide_ogp_form"><i class="icon-remove icon-white"></i> <?php _e('Cancel',$this->plugin_text_domain); ?></button>
		</div>
	</div>
	<?php wp_nonce_field($this->plugin_slug.'_save_ogp_object',$this->plugin_option_pref.'_nonce_options_save_ogp_object'); ?>
<?php echo $form->end();
?>
<h2><?php _e('Preview',$this->plugin_text_domain); ?></h2>
<?php
echo $this->render_ogp_tags($ogp);
?>
