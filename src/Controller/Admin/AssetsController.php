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
        $assets = $this->paginate($this->Assets);

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

        $asset = $this->Assets->newEntity();
        if ($this->request->is('post')) {
            $asset = $this->Assets->patchEntity($asset, $this->request->getData());
            if ($this->Assets->save($asset)) {
                $this->Flash->success(__('The asset has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset could not be saved. Please, try again.'));
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

        $asset = $this->Assets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $asset = $this->Assets->patchEntity($asset, $this->request->getData());
            if ($this->Assets->save($asset)) {
                $this->Flash->success(__('The asset has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset could not be saved. Please, try again.'));
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
        $asset = $this->Assets->get($id);
        if ($this->Assets->delete($asset)) {
            $this->Flash->success(__('The asset has been deleted.'));
        } else {
            $this->Flash->error(__('The asset could not be deleted. Please, try again.'));
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
        $asset = $this->Assets->get($id);

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
}
