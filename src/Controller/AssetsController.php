<?php
namespace Assets\Controller;

use Cake\Controller\Controller;

/**
 * Assets Controller
 *
 * @property \Assets\Model\Table\AssetsTable $Assets
 *
 * @method \Assets\Model\Entity\Asset[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AssetsController extends AppController
{

    /**
     * Download method
     *
     * @param string|null $id Asset id.
     * @return static
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function download($id = null)
    {
        $file = $this->loadModel()->getFile($id);

        $response = $this->response
            ->withModified(filemtime($file->pwd()));

        if ($response->checkNotModified($this->request)) {
            return $response;
        }

        return $response->withFile($file->pwd())
            ->withType(strtolower($file->ext()));
    }
}
