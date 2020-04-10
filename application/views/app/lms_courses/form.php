<?php $this->load->view('app/_layouts/header'); ?>
<?php $this->load->view('app/_layouts/sidebar'); ?>
<?php $this->load->view('app/_layouts/content'); ?>

<div class="col-12 col-xl-7 u-mv-small">

    <form action="<?php echo base_url('app/lms_courses/process') ?>"  method="post" enctype="multipart/form-data">

        <?php $this->load->view('app/_layouts/alert'); ?>

        <div class="c-stage u-mb-zero">

            <div class="c-stage__header o-media u-justify-start <?php echo ($this->input->get('editcourse') == 'false') ? 'u-hidden' : '' ?>">
                <div class="c-stage__header-title o-media__body">
                    <?php if (!empty($data)): ?>
                        <input name="id" type="hidden" value="<?php echo $data['id'] ?>">
                    <?php endif ?>           
                    <button class="c-btn c-btn--info c-btn--custom" name="publish" type="submit" title="publish">
                        <i class="fa fa-send-o" aria-hidden="true"></i>
                    </button>
                    <?php if (!empty($data)): ?>
                        <button class="u-ml-small c-btn c-btn--primary c-btn--custom" type="submit" name="save" title="save" value="<?php echo uri_string(); ?>">
                            <i class="fa fa-save" aria-hidden="true"></i>
                        </button>
                    <?php endif ?>
                </div>
                <div class="u-ml-auto" style="min-width: 150px">
                    <div class="c-toggle">
                        <div class="c-toggle__btn <?php echo (!empty($data['status'])) ? ($data['status'] == 'Published') ? 'is-active' : '' : ''?>">
                            <label class="c-toggle__label" for="publish">
                                <input value="Published" class="c-toggle__input" id="publish" name="status" type="radio" <?php echo (!empty($data['status'])) ? ($data['status'] == 'Published') ? 'checked' : '' : ''?>>Publish
                            </label>
                        </div>

                        <div class="c-toggle__btn <?php echo (!empty($data['status'])) ? ($data['status'] == 'Draft') ? 'is-active' : '' : 'is-active'?>">
                            <label class="c-toggle__label" for="draft">
                                <input value="Draft" class="c-toggle__input" id="draft" name="status" type="radio" <?php echo (!empty($data['status'])) ? ($data['status'] == 'Draft') ? 'checked' : '' : 'checked' ?>>Draft
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="c-stage__panel u-p-zero">

                <div class="row">
                    <div class="col-12 col-lg-12">                        
                        <div class="c-field u-ph-medium u-pv-small">
                            <label class="c-field__label">title : </label>
                            <input required class="c-input" name="title" type="text" placeholder="title" value="<?php echo (!empty($data['title']) ? $data['title'] : '') ?>">
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">             
                        <div class="c-field u-pv-small u-ph-medium">
                            <label class="c-field__label">category : </label>

                            <select name="category" class="select2-search">
                                <option></option>
                                <?php
                                foreach ($categorys as $category_name => $child_category) {

                                    echo "<optgroup label='".$category_name."'>";

                                    foreach ($child_category as $category) {
                                        if (!empty($data['id_sub_category']) AND $data['id_sub_category'] == $category['id_sub_category']) {
                                            echo "<option value='".$category['id_category']."__".$category['id_sub_category']."' selected>".$category['name']."</option>";
                                        }else {
                                            echo "<option value='".$category['id_category']."__".$category['id_sub_category']."'>".$category['name']."</option>";
                                        }
                                    }

                                    echo "</optgroup>";
                                }

                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">             
                        <div class="c-field u-pv-small u-ph-medium">
                            <label class="c-field__label">Image : </label>
                            <div class="c-field has-addon-right">
                                <input value="<?php echo (!empty($data['image']) ? $data['image'] : '') ?>" require name="image" class="c-input" id="image" type="text">
                                <span class="u-ml-auto c-field__addon">
                                    <button id='button-filemanager' data-src="<?php echo base_url(PATH_FILE_MANAGER."?type=1&relative_url=1&field_id=image&multiple=0&akey=".$this->session->userdata('key')) ?>" class="c-btn c-btn--fancy u-p-xsmall" type="button" data-toggle="modal" data-target="#modal-filemanager">
                                        <i class="fa fa-search"></i>
                                    </button>

                                </span>
                            </div>
                        </div>     
                    </div>                        

                </div> 

                <ul class="c-tabs__list nav nav-tabs u-ph-zero u-pv-small" role="tablist">
                    <li>
                        <a class="c-tabs__link u-p-small u-mr-zero u-bg-secondary active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">description</a>
                    </li>

                    <li>
                        <a class="c-tabs__link u-p-small u-mr-zero u-bg-secondary" id="nav-faq-tab" data-toggle="tab" href="#nav-faq" role="tab" aria-controls="nav-faq" aria-selected="false">faq</a>
                    </li>
                </ul> 

                <div class="c-tabs__content tab-content" id="nav-tabContent">
                    <div class="c-tabs__pane active u-p-zero" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">

                        <div class="c-field">
                            <textarea required class="editor" name="description">
                                <?php echo (!empty($data['description']) ? $data['description'] : '') ?>
                            </textarea>
                        </div>  

                    </div>
                    <div class="c-tabs__pane u-p-zero" id="nav-faq" role="tabpanel" aria-labelledby="nav-faq-tab">

                        <div class="c-field">
                            <textarea required class="editor" name="faq">
                                <?php echo (!empty($data['faq']) ? $data['faq'] : '') ?>
                            </textarea>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </form>
</div>

<div class="col-12 col-xl-5 u-mv-small">
    <div class="c-stage u-mb-zero">

        <?php if (!empty($data)): ?>
            <div class="c-stage__header o-media u-justify-start <?php echo ($this->input->get('editsection') == 'false') ? 'u-hidden' : '' ?>">
                <div class="o-media">
                    <div class="c-stage__icon o-media__img">
                        <i class="fa fa-info"></i>
                    </div>
                    <div class="c-stage__header-title o-media__body">
                        <h6 class="u-mb-zero">Curriculum</h6>
                    </div>
                </div>
                <div class="u-ml-auto o-line">                       
                    <button type="button" data-modaltitle='Create Section' class="c-btn c-btn--fancy c-btn--custom u-mr-xsmall button-section-create" data-toggle="modal" data-target="#modal-section"> 
                        Section
                    </button>           
                    <?php if (!empty($section)): ?>   
                        <button type="button" class="c-btn c-btn--primary c-btn--custom u-mr-xsmall" data-toggle="modal" data-target="#modal-section-sort"> 
                            Sort Section
                        </button>
                    <?php endif ?>
                </div>
            </div>

            <div class="c-stage__panel u-p-xsmall <?php echo ($this->input->get('editsection') == 'false') ? 'u-hidden' : '' ?>">

                <?php if (empty($section)): ?>
                    <div class="c-alert c-alert--info">
                        No section found. Create first
                    </div>
                <?php endif ?>

                <?php if (!empty($section)): ?>
                    <div class="c-stage u-mb-zero">
                        <?php 
                        $no_section = 1;
                        foreach ($section as $section_data): ?>   

                            <?php  
                            $lesson = $this->M_LMS_Courses->data_lesson($section_data['id']);
                            ?>                                                                            

                            <div class="c-stage__header o-media u-justify-start">
                                <div class="c-stage__header-title o-media__body">
                                    <h6 class="u-mb-zero">Section <?php echo $no_section++; ?> : <?php echo $section_data['title'] ?></h6>
                                </div>
                                <div class="u-ml-auto o-line">                       
                                    <a class="c-btn--custom c-btn c-btn--success u-mr-xsmall" href="<?php echo base_url('app/lms_courses/create_lesson/'.$section_data['id']) ?>">
                                        Lesson
                                    </a>
                                    <?php if (!empty($lesson)): ?>   
                                        <button type="button" class="c-btn c-btn--primary c-btn--custom u-mr-xsmall" data-toggle="modal" data-target="#modal-lesson-sort-<?php echo $section_data['id'] ?>"> 
                                            Sort Lesson
                                        </button>
                                    <?php endif ?>
                                    <button type="button" class="c-btn c-btn--info c-btn--custom u-mr-xsmall button-section-update" data-id='<?php echo $section_data['id'] ?>' data-modaltitle='Update Section' data-title='<?php echo $section_data['title'] ?>' data-toggle="modal" data-target="#modal-section"> 
                                        <i class="fa fa-edit"></i>
                                    </button> 
                                    <button data-title="are you sure ?" data-text="want to delete section : <?php echo $section_data['title'] ?>" class="c-btn--custom c-btn--small c-btn c-btn--danger single-action" data-id="$1" data-href="<?php echo base_url('app/lms_courses/process_section_delete/'.$section_data['id']) ?>" type="button"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>

                            <?php if (empty($lesson)): ?>
                                <div class="c-stage__panel u-p-xsmall" >
                                    <div class="c-alert c-alert--success">
                                        Create lesson first.
                                    </div>
                                </div>
                            <?php endif ?>

                            <?php if (!empty($lesson)): ?>
                                <div class="c-stage__panel u-p-xsmall" >
                                    <?php 
                                    $no_lesson = 1;
                                    foreach ($lesson as $lesson_data): ?>
                                        <div class="c-stage__header o-media u-justify-start" style="background: #1d2531">
                                            <div class="c-stage__header-title o-media__body">
                                                <h6 class="u-mb-zero u-text-white">
                                                    Lesson <?php echo $no_lesson++ ?> : <?php echo $lesson_data['title'] ?>
                                                </h6>
                                            </div>
                                            <div class="u-ml-auto o-line">  
                                                <a class="c-btn--custom c-btn c-btn--info u-mr-xsmall" href="<?php echo base_url('app/lms_courses/update_lesson/'.$section_data['id'].'/'.$lesson_data['id']) ?>">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button data-title="are you sure ?" data-text="want to delete lesson : <?php echo $lesson_data['title'] ?>" class="c-btn--custom c-btn--small c-btn c-btn--danger single-action" data-id="$1" data-href="<?php echo base_url('app/lms_courses/process_lesson_delete/'.$lesson_data['id']) ?>" type="button"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>

                        <?php endforeach ?>
                    </div>
                <?php endif ?>

            </div>

        <?php endif ?>

    </div>
</div>

<?php if (!empty($data)): ?>
    <?php $this->load->view('app/lms_courses/form-section',$data); ?>
<?php endif ?>

<?php if (!empty($section)): ?>
    <?php $this->load->view('app/lms_courses/form-section-sort',['section' => $section]); ?>
    <?php 
    $no_section = 1;
    foreach ($section as $section_data): ?>   
        <?php  
        $lesson = $this->M_LMS_Courses->data_lesson($section_data['id']);
        ?>                                        
        <?php if (!empty($lesson)): ?>
            <?php $this->load->view('app/lms_courses/form-lesson-sort',[
                'data' => $data, 
                'section' => $section_data,
                'lesson' => $lesson
            ]); ?>
        <?php endif ?> 
    <?php endforeach ?>
<?php endif ?>

<?php $this->load->view('app/_layouts/modal_filemanager'); ?>
<?php $this->load->view('app/_layouts/footer'); ?>