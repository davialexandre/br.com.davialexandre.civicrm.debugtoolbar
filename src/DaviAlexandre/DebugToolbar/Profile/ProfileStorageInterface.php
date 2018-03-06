<?php

namespace DaviAlexandre\DebugToolbar\Profile;


interface ProfileStorageInterface {

  public function read($identifier);

  public function write(Profile $profile);

}
