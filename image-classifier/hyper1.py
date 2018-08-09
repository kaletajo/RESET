
# Simple CNN model for N category Dataset
# - Uses colour RGB images
#
# Hyper-parameter search program.
# Searches across a range of values for hyper-parameters.
# -
'''
   Usage:

           python3  hyper1.py

   Reads image data under 'data' directory.

'''

import numpy as np
import os,sys


from keras.models import Sequential
from keras.layers import Dense
from keras.layers import Dropout
from keras.layers import Flatten
from keras.constraints import maxnorm
from keras.optimizers import SGD
from keras.optimizers import Adam
from keras.optimizers import Adadelta
from keras.layers.convolutional import Convolution2D
from keras.layers.convolutional import MaxPooling2D
from keras import metrics
from keras.utils import np_utils
from keras import backend as K
K.set_image_dim_ordering('th')


from skimage.io import imread
from skimage.transform import resize
import glob


# Set image size
new_width  = 32
new_height = 32


if K.image_data_format() == 'channels_first':
    input_shape = (3, new_width, new_height)
else:
    input_shape = (new_width, new_height, 3)




# fix random seed for reproducibility
seed = 7
np.random.seed(seed)




def load_from_dir(input_dir):

    # Set size variables
    all_images = []
    all_labels = []

    #print('K. = ' , K.image_data_format())

    path = os.path.join(input_dir, '*', '*.*')
    print("input_dir = ", path)
    files = glob.glob(path)
    for fl in files:
        dir = os.path.split(fl)[0]
        class_label = os.path.split(dir)[1]
        class_label = class_label.split('-')[0]
        new_img = np.array(resize(imread(fl), (new_width, new_height)) )
        all_images.append(new_img)
        all_labels.append([class_label])

    x_train = np.array(all_images)
    y_train = np.array(all_labels)
    return x_train, y_train


def load_data(input_dir):
    train_path = os.path.join(input_dir,"train")
    print("train_path = ", train_path)
    X_train, y_train = load_from_dir(train_path)
    test_path = os.path.join(input_dir,"test")
    print("test_path = ", test_path)
    X_test, y_test = load_from_dir(test_path)
    return (X_train, y_train), (X_test, y_test)



# Load data
(X_train, y_train), (X_test, y_test) = load_data("data")



print('type(X_train) = ', type(X_train), ' X_train.shape ', X_train.shape)
print('type(y_train) = ', type(y_train), ' y_train.shape ', y_train.shape)
print('type(X_test) = ', type(X_test), ' X_test.shape ', X_test.shape)
print('type(y_test) = ', type(y_test), ' y_test.shape ', y_test.shape)
x1 = X_train[0]
print('type(x1) = ', type(x1), ' x1.shape ', x1.shape)
## sys.exit(0)



# normalize inputs from 0-255 to 0.0-1.0
X_train = X_train.astype('float32')
X_test = X_test.astype('float32')
X_train = X_train / 255.0
X_test = X_test / 255.0



# one hot encode outputs
y_train_ohe = np_utils.to_categorical(y_train)
y_test_ohe = np_utils.to_categorical(y_test)
num_classes = y_test_ohe.shape[1]


results = []


# Define Hyper-parameter search

for epochs in [5, 50, 100, 500, 1000]:
  for batch_size in [8, 16, 32, 64, 128]:
    for lrate in [0.000001, 0.00001, 0.0001, 0.001, 0.01, 0.1, 0.5, 1.0, 5.0, 10.0, 100.0]:
      #for rho in [0.1, 0.25, 0.5, 0.7, 0.8, 0.9, 1.0]:
      for truefalse in [0, 1]:


        print('============================================================================')
        print('epochs ', epochs, ' batch_size ', batch_size, ' lrate ', lrate, ' truefalse ', truefalse)

        # Create the model
        model = Sequential()
        model.add(Convolution2D(32, 3, 3, input_shape=(32, 32, 3), border_mode='same', activation='relu', W_constraint=maxnorm(3)))
        model.add(Dropout(0.2))
        model.add(Convolution2D(32, 3, 3, activation='relu', border_mode='same', W_constraint=maxnorm(3)))
        model.add(MaxPooling2D(pool_size=(2, 2)))
        model.add(Flatten())
        model.add(Dense(512, activation='relu', W_constraint=maxnorm(3)))
        model.add(Dropout(0.5))
        model.add(Dense(num_classes, activation='softmax'))


        # Compile model
        ###epochs = 20
        ###lrate = 0.05
        ###rho = 0.95
        decay = lrate/epochs
        #sgd = SGD(lr=lrate, momentum=0.9, decay=decay, nesterov=False)

        if (truefalse == 0):
          adam = Adam(lr=lrate, beta_1=0.9, beta_2=0.999, epsilon=1e-8, decay=decay, amsgrad=False)
        else:
          adam = Adam(lr=lrate, beta_1=0.9, beta_2=0.999, epsilon=1e-8, decay=decay, amsgrad=True)

        #adadelta = Adadelta(lr=1.0, rho=0.95, epsilon=None, decay=0.0)                   # 42.34%  !!
        #adadelta = Adadelta(lr=1.0, rho=0.90, epsilon=None, decay=decay)                   # 36%
        #adadelta = Adadelta(lr=lrate, rho=rho, epsilon=None, decay=decay)                  

        model.compile(loss='categorical_crossentropy', optimizer=adam, metrics=['accuracy'])


        print(model.summary())

        # Fit the model
        ###batch_size = 64   
        model.fit(X_train, y_train_ohe, validation_data=(X_test, y_test_ohe), epochs=epochs, batch_size=batch_size, verbose=2)

        # Final evaluation of the model
        scores = model.evaluate(X_test, y_test_ohe, verbose=0)
        print("Accuracy: %.2f%%" % (scores[1]*100))

    
        # Store reults in correct format
        final_accuracy = scores[1]*100
        final_result = (epochs, batch_size, lrate, decay, truefalse, final_accuracy)
        results.append(final_result)


print('epochs, batch_size, lrate, decay, truefalse, final_accuracy')
for r in results:
  print(r)
  


