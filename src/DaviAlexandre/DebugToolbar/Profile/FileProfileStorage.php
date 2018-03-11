<?php

namespace DaviAlexandre\DebugToolbar\Profile;

use Civi\Core\Paths;

class FileProfileStorage implements ProfileStorageInterface {

  public function __construct(Paths $paths) {
    $this->storageFolder = $paths->getPath('[civicrm.files]/debug_toolbar/profiles');

    if(!$this->createFolderRecursive($this->storageFolder)) {
      throw new \RuntimeException('It was not possible to create the storage folder for Profiles at ' . $this->storageFolder);
    }
  }

  public function read($identifier) {
    $profilePath = $this->getProfileFolder($identifier) . '/' . $identifier;

    if(!file_exists($profilePath)) {
      throw new \RuntimeException('It was not possible to find the Profile with the identifier '. $identifier);
    }

    return unserialize(file_get_contents($profilePath));
  }

  public function write(Profile $profile) {
    $profileFolder = $this->getProfileFolder($profile->getIdentifier());

    if(!$this->createFolderRecursive($profileFolder)) {
      throw new \RuntimeException('It was not possible to create the storage folder for Profiles at ' . $profileFolder);
    }

    $profilePath = $profileFolder . '/' . $profile->getIdentifier();
    file_put_contents($profilePath, serialize($profile));
  }

  public function getProfileFolder($identifier) {
    $folder1 = substr($identifier,0, 2);
    $folder2 = substr($identifier,2, 2);

    return $this->storageFolder . '/' . $folder1 . '/' . $folder2;
  }

  private function createFolderRecursive($folder) {
    // The double is_dir call is useful to avoid rare race conditions as described
    // in https://github.com/kalessil/phpinspectionsea/blob/master/docs/probable-bugs.md#mkdir-race-condition
    return !(
      !is_dir($folder) &&
      false === mkdir($folder, 0777, true) &&
      !is_dir($folder)
    );
  }
}
