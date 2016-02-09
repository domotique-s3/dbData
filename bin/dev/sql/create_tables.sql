CREATE TABLE measurments (
    timestamp DOUBLE PRECISION NOT NULL,
    sensor_id INTEGER NOT NULL,
    unit INTEGER NOT NULL,
    value DOUBLE PRECISION NOT NULL
);

CREATE TABLE measurmentsone (
    sensor_id INTEGER NOT NULL,
    value DOUBLE PRECISION NOT NULL,
    timestamp DOUBLE PRECISION NOT NULL
);

CREATE TABLE measurmentstwo (
    sensor_id INTEGER NOT NULL,
    value DOUBLE PRECISION NOT NULL,
    timestamp DOUBLE PRECISION NOT NULL
);
