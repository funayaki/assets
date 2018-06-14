<?php
namespace Assets\Controller\Admin;

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
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $assets = $this->paginate($this->getAssetsTable(), [
            'order' => [
                'Assets.created' => 'desc'
            ]
        ]);

        $this->set(compact('assets'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setTemplate('form');

        $asset = $this->getAssetsTable()->newEntity();
        if ($this->request->is('post')) {
            $asset = $this->getAssetsTable()->patchEntity($asset, $this->request->getData());
            if ($this->getAssetsTable()->save($asset)) {
                $this->Flash->success(__d('funayaki', 'The asset has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__d('funayaki', 'The asset could not be saved. Please, try again.'));
        }
        $this->set(compact('asset'));
    }

    /**
     * Edit method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setTemplate('form');

        $asset = $this->getAssetsTable()->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $asset = $this->getAssetsTable()->patchEntity($asset, $this->request->getData());
            if ($this->getAssetsTable()->save($asset)) {
                $this->Flash->success(__d('funayaki', 'The asset has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__d('funayaki', 'The asset could not be saved. Please, try again.'));
        }
        $this->set(compact('asset'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Asset id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $asset = $this->getAssetsTable()->get($id);
        if ($this->getAssetsTable()->delete($asset)) {
            $this->Flash->success(__d('funayaki', 'The asset has been deleted.'));
        } else {
            $this->Flash->error(__d('funayaki', 'The asset could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer([
            'action' => 'index'
        ]));
    }

    /**
     * Download method
     *
     * @param string|null $id Asset id.
     * @return static
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function download($id = null)
    {
        $asset = $this->getAssetsTable()->get($id);

        $file = ROOT . DS . $asset->dir . $asset->file_name;

        $response = $this->response
            ->withModified(filemtime($file));

        if ($response->checkNotModified($this->request)) {
            return $response;
        }

        $extension = pathinfo($file, PATHINFO_EXTENSION);
        return $response->withFile($file)
            ->withType(strtolower($extension));
    }

    /**
     * @return \Assets\Model\Table\AssetsTable
     */
    protected function getAssetsTable()
    {
        return $this->Assets;
    }
}
