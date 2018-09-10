
# USAGE
# python3 train_network.py --dataset images --model new1.model

# set the matplotlib backend so figures can be saved in the background
import matplotlib
matplotlib.use("Agg")

# import the necessary packages
from keras.preprocessing.image import ImageDataGenerator
from keras.optimizers import SGD, Adam, Adadelta, RMSprop
from sklearn.model_selection import train_test_split
from keras.preprocessing.image import img_to_array
from keras.utils import to_categorical
from keras import backend as K
from keras.models import Sequential
from keras.layers.convolutional import Conv2D
from keras.layers.convolutional import MaxPooling2D
from keras.layers.convolutional import ZeroPadding2D
from keras.layers.core import Activation
from keras.layers.core import Flatten
from keras.layers.core import Dense
from keras.layers.core import Dropout
from keras import regularizers
from imutils import paths
import matplotlib.pyplot as plt
import numpy as np
import argparse
import random
import cv2
import os

# construct the argument parse and parse the arguments
ap = argparse.ArgumentParser()
ap.add_argument("-d", "--dataset", required=True,
	help="path to input dataset")
ap.add_argument("-m", "--model", required=True,
	help="path to output model")
ap.add_argument("-p", "--plot", type=str, default="plot.png",
	help="path to output loss/accuracy plot")
args = vars(ap.parse_args())

# initialize the number of epochs to train for, and initial learning rate,
# and batch size
EPOCHS = 5
INIT_LR = 1e-3
BS = 32

# initialize the data and labels
print("[INFO] loading images...")
data = []
labels = []


# Set image size and channel and dims ordering
K.set_image_dim_ordering('tf')
new_width  = 128 
new_height = 128
num_channels = 3

if K.image_data_format() == 'channels_first':
    input_shape = (num_channels, new_height, new_width)
else:
    input_shape = (new_height, new_width, num_channels)


# grab the image paths and randomly shuffle them
imagePaths = sorted(list(paths.list_images(args["dataset"])))
random.seed(1)
random.shuffle(imagePaths)



# Start timing...
import time
start_time = time.time()



# loop over the input images
for imagePath in imagePaths:
	# load the image, pre-process it, and store it in the data list
	image = cv2.imread(imagePath)
	image = cv2.resize(image, (new_width, new_height))
	image = img_to_array(image)
	data.append(image)

	# extract the class label from the image path and update the
	# labels list
	label = imagePath.split(os.path.sep)[-2]
	label = label.split('-')[0]
	labels.append(label)


# get number of classes
num_classes = len(set(labels))



# scale the raw pixel intensities to the range [0, 1]
data = np.array(data, dtype="float") / 255.0
labels = np.array(labels)

# partition the data into training and testing splits using 80% of
# the data for training and the remaining 20% for testing
(trainX, testX, trainY, testY) = train_test_split(data,
	labels, test_size=0.20, random_state=42)




# convert the labels from integers to vectors
trainY = to_categorical(trainY, num_classes=num_classes)
testY = to_categorical(testY, num_classes=num_classes)

# construct the image generator for data augmentation
aug = ImageDataGenerator(rotation_range=30, width_shift_range=0.1,
	height_shift_range=0.1, shear_range=0.2, zoom_range=0.2,
	horizontal_flip=True, fill_mode="nearest")

# initialize the model
print("[INFO] compiling model...")

def buildModel(input_shape, num_classes):
	# initialize the model
	model = Sequential()

        # L2 regularization param
	L2_value = 0.001

	# first set of CONV => RELU => POOL layers
	model.add(Conv2D(32, (5, 5), padding="same", kernel_regularizer=regularizers.l2(L2_value), input_shape=input_shape))
	model.add(Activation("relu"))
	###model.add(Dropout(0.5))
	model.add(MaxPooling2D(pool_size=(2, 2), strides=(2, 2)))

	# second set of CONV => RELU => POOL layers
	model.add(Conv2D(64, (5, 5), padding="same", kernel_regularizer=regularizers.l2(L2_value)))
	model.add(Activation("relu"))
	model.add(MaxPooling2D(pool_size=(2, 2), strides=(2, 2)))

	# third set of CONV => RELU => POOL layers
	model.add(Conv2D(128, (5, 5), padding="same", kernel_regularizer=regularizers.l2(L2_value)))
	model.add(Activation("relu"))
	model.add(MaxPooling2D(pool_size=(2, 2), strides=(2, 2)))

	# fourth set of CONV => RELU => POOL layers
	model.add(Conv2D(256, (5, 5), padding="same", kernel_regularizer=regularizers.l2(L2_value)))
	model.add(Activation("relu"))
	model.add(MaxPooling2D(pool_size=(2, 2), strides=(2, 2)))


	# first (and only) set of FC => RELU layers
	model.add(Flatten())
	model.add(Dense(512))
	model.add(Activation("relu"))

	# softmax classifier
	model.add(Dense(num_classes))
	model.add(Activation("softmax"))

	# return the constructed network architecture
	return model



def VGG_19 (input_shape, num_classes):
    model = Sequential()
    model.add(ZeroPadding2D((1,1),input_shape=input_shape))
    model.add(Conv2D(64, (3, 3), activation='relu'))
    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(64, (3, 3), activation='relu'))
    model.add(MaxPooling2D((2,2), strides=(2,2)))

    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(128, (3, 3), activation='relu'))
    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(128, (3, 3), activation='relu'))
    model.add(MaxPooling2D((2,2), strides=(2,2)))

    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(256, (3, 3), activation='relu'))
    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(256, (3, 3), activation='relu'))
    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(256, (3, 3), activation='relu'))
    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(256, (3, 3), activation='relu'))
    model.add(MaxPooling2D((2,2), strides=(2,2)))

    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(512, (3, 3), activation='relu'))
    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(512, (3, 3), activation='relu'))
    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(512, (3, 3), activation='relu'))
    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(512, (3, 3), activation='relu'))
    model.add(MaxPooling2D((2,2), strides=(2,2)))

    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(512, (3, 3), activation='relu'))
    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(512, (3, 3), activation='relu'))
    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(512, (3, 3), activation='relu'))
    model.add(ZeroPadding2D((1,1)))
    model.add(Conv2D(512, (3, 3), activation='relu'))
    model.add(MaxPooling2D((2,2), strides=(2,2)))

    model.add(Flatten())
    model.add(Dense(4096, activation='relu'))
    model.add(Dropout(0.5))
    model.add(Dense(4096, activation='relu'))
    model.add(Dropout(0.5))
    model.add(Dense(num_classes, activation='softmax'))

    return model






model = buildModel(input_shape, num_classes=num_classes)
###model = VGG_19(input_shape, num_classes=num_classes)



optimizer = Adam(lr=INIT_LR, decay=INIT_LR / EPOCHS)
#optimizer = SGD(lr=lrate, momentum=0.9, decay=decay, nesterov=False)
#optimizer = SGD(lr=0.01, decay=1e-6, momentum=0.9, nesterov=True)
#optimizer = Adam(lr=lrate, beta_1=0.9, beta_2=0.999, epsilon=1e-8, decay=0.0, amsgrad=False)
#optimizer = Adadelta(lr=INIT_LR, rho=0.95, epsilon=1e-8,  decay=INIT_LR / EPOCHS)
#optimizer = Adadelta(lr=1.0, rho=0.95, epsilon=None, decay=0.0)                   # 42.34%  !!
#optimizer = Adadelta(lr=1.0, rho=0.90, epsilon=None, decay=decay)                   # 36%
#optimizer = RMSprop(lr=0.001)




model.compile(loss="categorical_crossentropy", optimizer=optimizer, metrics=["accuracy"])

# train the network
print("[INFO] training network...")
H = model.fit_generator(aug.flow(trainX, trainY, batch_size=BS),
	validation_data=(testX, testY), steps_per_epoch=len(trainX) // BS,
	epochs=EPOCHS, verbose=1)

# save the model to disk
print("[INFO] serializing network...")
model.save(args["model"])

# plot the training loss and accuracy
plt.style.use("ggplot")
plt.figure()
N = EPOCHS
plt.plot(np.arange(0, N), H.history["loss"], label="train_loss")
plt.plot(np.arange(0, N), H.history["val_loss"], label="val_loss")
plt.plot(np.arange(0, N), H.history["acc"], label="train_acc")
plt.plot(np.arange(0, N), H.history["val_acc"], label="val_acc")
plt.title("Training Loss and Accuracy on RESET (3 classes)")
plt.xlabel("Epoch #")
plt.ylabel("Loss/Accuracy")
plt.legend(loc="lower left")
plt.savefig(args["plot"])

# End timed run
print("--- %s seconds ---" % (time.time() - start_time))

# configure batch size and retrieve one batch of augmented images
for X_batch, y_batch in aug.flow(trainX, trainY, batch_size=9, save_to_dir='augmented', save_prefix='aug', save_format='png'):
	# create a grid of 3x3 images
	for i in range(0, 9):
		plt.subplot(330 + 1 + i)
		plt.imshow(X_batch[i].reshape(new_height, new_width, num_channels))
	# show the plot
	plt.show()
	break



print("---> ", H.history["val_acc"])


